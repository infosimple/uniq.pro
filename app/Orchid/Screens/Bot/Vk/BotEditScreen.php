<?php

namespace App\Orchid\Screens\Bot\Vk;

use App\Http\Requests\BotVkRequest;
use App\Models\Bot\Bot;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
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
        return [
            Layout::tabs([
                'Основное' => Layout::rows([
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
                    Input::make('bot.user_token')
                        ->title('Токен пользователя')
                        ->required(),
                ]),
                'Доступ к боту' => Layout::rows([
                    CheckBox::make('bot.invite')
                        ->sendTrueOrFalse()
                        ->placeholder('Только по инвайту'),

                    Input::make('bot.vk_days')
                        ->title('Время существования аккаунта в днях')
                        ->required(),

                ]),
            ]),


        ];
    }

    public function createOrUpdate(Bot $bot, BotVkRequest $request)
    {
        $chekBotExist = Bot::getBotSocial('vk');
        $exists = $bot->exists;
        if ($chekBotExist AND !$exists) {
            Alert::warning('У вас уже существует бот ВК');
            return redirect()->route('bots.list');
        }

        $dataBot = $request->bot;
        $config = collect($dataBot)
            ->filter(function ($value, $key) {
                return $key !== 'name';
            })->toArray();
        $dataBot['config'] = $config;
        $dataBot['soc'] = 'vk';
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
