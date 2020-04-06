<?php

namespace App\Models\Bot\Vk;

use App\Core\Bot\Vk\Response\ActionResponse;
use App\Models\Bot\Bot;
use App\Models\Users\Social\Vk\VkUser;
use Illuminate\Database\Eloquent\Model;
use Orchid\Platform\Models\User;
use VK\Client\VKApiClient;

class Moderation extends Model
{
    protected $fillable = [
        'data',
        'moderator_id',
        'status',
        'deadline'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function addTask(array $data, int $minutes = null)
    {
        $minutes = now()->addMinutes($minutes)->toDate();
        $moderator = $this->getModerator();
        $this->create(['data' => json_encode($data), 'deadline' => $minutes, 'moderator_id' => $moderator->id]);
        $this->sendModerationVk($moderator, 'moderationMessageTask');
    }

    public function sendModerationVk(User $moderator, $method, $badAnswer = null, $var = null)
    {
        $bot = Bot::where('soc', 'vk')->first();
        $actionResponse = new ActionResponse(new VKApiClient($bot->config['version']), $bot, $moderator->vkuser);

        $sumTasks = $this->sumTasks($moderator);
        if ($sumTasks > 1) {
            $var['sumTasks'] = $sumTasks;
            $actionResponse->getMessageMethod($method . 's', $badAnswer, $var);
        } else {
            $actionResponse->getMessageMethod($method, $badAnswer, $var);
        }
    }

    public function getModerator(int $idModerate = null)
    {
        $moderators = User::getModerators();
        if (!$idModerate and $this->all()->count()) {
            $idModerate = $this->all()->last()->moderator_id;
        }
        $moderator = $moderators->where('id', '>', $idModerate)->first();
        if (!$moderator) {
            $moderator = $moderators->first();
        }
        return $moderator;
    }

    public function sumTasks(User $moderator): int
    {
        return $this->where(['moderator_id' => $moderator->id, 'status' => 0])->get()->count();
    }

    public function nextModerationVk()
    {
        $oldModerator = $this->moderator;
        $newModerator = $this->getModerator($oldModerator->id);
        if ($oldModerator->id == $newModerator->id) {
            $this->sendModerationVk($newModerator, 'moderationMessageTask', true);
        } else {
            $this->updateTask($newModerator);
            $this->sendModerationVk($oldModerator, 'comeBackTask');
            $this->sendModerationVk($newModerator, 'moderationMessageTask');
        }
    }
    public function updateTask(User $moderator, int $minutes = null)
    {
        $minutes = now()->addMinutes($minutes)->toDate();
        $this->update(['deadline' => $minutes, 'moderator_id' => $moderator->id]);
    }
    public static function approveTasks($vkId, $answer){
        $moderator = User::where('vk_user_id', $vkId)->first();
        $tasks = static::where(['moderator_id' => $moderator->id, 'status' => 0])->get();
        $bot = Bot::where('soc', 'vk')->first();
        $user = VkUser::find($vkId);
        $actionResponse = new ActionResponse(new VKApiClient($bot->config['version']), $bot, $user);

        if($answer == 'good'){
            $tasks->update(['status' => 1]);
            $actionResponse->sendMessageModerator('Все задания приняты, чтобы их выполнить, вам необходимо перейти на сайт UNIQ.pro');
        }elseif ($answer == 'bad'){
            $tasks->update(['status' => 2]);
            $actionResponse->getMessageMethod('menuModerator', true);
        }elseif (is_int($answer)){
            $moderator->sleepModerator($answer);
            $actionResponse->getMessageMethod('sleepModerator', true);
        }
    }
}
