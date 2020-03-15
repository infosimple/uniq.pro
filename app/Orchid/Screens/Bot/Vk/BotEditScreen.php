<?php

namespace App\Orchid\Screens\Bot\Vk;

use App\Models\Bot\Bot;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class BotEditScreen extends Screen
{

    public $name = 'Создание ВК бота';
    public $description = 'Еще один бот';

    //Переменная определяющая редактирование или создание бота
    public $exists = false;


    public function query(Bot $bot = null): array
    {
        if (!$bot) {
            abort(404);
        }

        $this->exists = $bot->exists;
        if ($this->exists) {
            $this->name = 'Vk бот: ' . $bot->name;
            $this->description = 'Изменение бота';
        }

        $botDate = collect($bot->config);
        $botDate = $botDate->merge($bot->attributesToArray());

        return [
            'bot' => $botDate
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Назад')
                ->route('bots.list')
                ->icon('icon-arrow-left')
                ->class('btn btn-default'),

            Button::make('Создать')
                ->icon('icon-plus')
                ->class('btn btn-success btn-block')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Обновить')
                ->icon('icon-note')
                ->class('btn btn-warning btn-block')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('icon-trash')
                ->confirm(__('Вы уверены, что хотите удалить бота?'))
                ->class('btn btn-danger btn-block')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        //Форма вк бота
        return [
            Layout::rows([
                Input::make('bot.name')
                    ->title('Название бота')
                    ->placeholder('ВК бот')
                    ->required(),
                Input::make('bot.vk_key')
                    ->title('Токен сообщества')
                    ->placeholder('9961ea153f0b1cd0b1425f0b3ddca77f85d155614cd5257ab403824b4709377a19cc7e661cd638fc04867')
                    ->required(),
                Input::make('bot.access_key')
                    ->title('Ключ доступа')
                    ->placeholder('c8e976d6')
                    ->help('Строка, которую должен вернуть сервер')
                    ->required(),
                Input::make('bot.version')
                    ->title('Версия API VK')
                    ->placeholder('5.81')
                    ->required(),
                Input::make('bot.secret_key')
                    ->title('Секретный ключ')
                    ->placeholder('fdget345f')
                    ->required(),
                Input::make('bot.group_id')
                    ->title('ID группы')
                    ->placeholder('9525456875')
                    ->required(),
            ])
        ];
    }

    public function createOrUpdate(Bot $bot, Request $request)
    {

        $message = [
            'bot.vk_key.size' => 'Токен сообщества должен состоять из 85 символов',
            'bot.group_id.between' => 'ID группы должен состоять из 9 цифр',
            'bot.group_id.integer' => 'ID группы должен состоять только из цифр',
        ];
        $request->validate([
            'bot.vk_key' => 'size:85',
            'bot.group_id' => 'integer|between:000000001,999999999'
        ], $message);

        $dataBot = $request->bot;
        $dataBot['config'] = [
            'vk_key' => $request->bot['vk_key'],
            'access_key' => $request->bot['access_key'],
            'version' => $request->bot['version'],
            'secret_key' => $request->bot['secret_key'],
            'group_id' => $request->bot['group_id']
        ];
        $dataBot['soc'] = 'vk';
        $exists = $bot->exists;
        $bot->fill($dataBot)->save();
        if (!$exists) {
            Alert::info('Вы успешно создали Vk бота: ' . $request->bot['name']);
            return redirect()->route('bots.list');
        } else {
            Alert::info('Вы успешно обновили Vk бота');
            return redirect()->route('bot.vk.edit', $bot->id);
        }

    }

    public function remove(Bot $bot)
    {
        $bot->delete()
            ? Alert::info('Вы успешно удалили бота')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('bots.list');
    }
}
