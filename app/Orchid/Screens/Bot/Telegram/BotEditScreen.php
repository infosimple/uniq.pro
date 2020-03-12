<?php

namespace App\Orchid\Screens\Bot\Telegram;

use App\Models\Bot\Bot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;

class BotEditScreen extends Screen
{

    public $name = 'Создание Telegram бота';
    public $description = 'Еще один бот';

    //Переменная определяющая редактирование или создание бота
    public $exists = false;

    public function query(Bot $bot = null): array
    {
        if (!$bot){
            abort(404);
        }

        $this->exists = $bot->exists;
        if ($this->exists) {
            $this->name = $bot->name;
            $this->description = 'Изменение бота';
        }

        return [
            'bot' => $bot
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
                ->class('btn btn-error btn-block')
                ->confirm(__('Вы уверены, что хотите удалить бота?'))
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
        //Форма телеграма
        return [
            $telegram = Layout::rows([
                Input::make('bot.name')
                    ->title('Название бота')
                    ->placeholder('Телеграмм бот')
                    ->help('Укажите название будущего бота'),
            ])
        ];
    }

    public function createOrUpdate(Bot $bot, Request $request)
    {
        $dataBot = $request->bot;

        $exists = $bot->exists;
        $bot->fill($dataBot)->save();
        if (!$exists) {
            Artisan::call('make:model Core/Bot/Method/Repository' . $bot->id);
            Alert::info('Вы успешно создали Telegram бота: ' . $request->bot['name']);
            return redirect()->route('bots.list');
        } else {
            Alert::info('Вы успешно обновили Telegram бота');
            return redirect()->route('bot.telegram.edit', $bot->id);
        }
    }
    public function remove(Bot $bot)
    {
        File::delete('..\app\Core\Bot\Method\Repository' . $bot->id . '.php');
        $bot->delete()
            ? Alert::info('Вы успешно удалили бота')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('bots.list');
    }
}
