<?php

namespace App\Orchid\Screens\Bot\Vk\Users;

use App\Models\Region;
use App\Models\Users\Social\Vk\VkUser;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class VkUserEditScreen extends Screen
{

    public $name = 'Изменение пользователя';
    public $description = '';

    public function query(VkUser $user): array
    {
        $this->description = $user->name;
        return [
            'user' => $user
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
                ->route('user.vk.list')
                ->icon('icon-arrow-left')
                ->class('btn btn-default'),

            Button::make('Обновить')
                ->icon('icon-note')
                ->class('btn btn-warning btn-block')
                ->method('update'),

            Button::make('Удалить')
                ->icon('icon-trash')
                ->class('btn btn-danger btn-block')
                ->method('remove'),
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
            Layout::rows([
                Input::make('user.vk_id')
                    ->title('Id пользователя')
                    ->required(),
                Select::make('user.status')
                    ->title('Статус пользователя')
                    ->options([
                        0 => 'Добавлен',
                        1 => 'На модерации',
                        2 => 'Приглашен',
                        3 => 'Активирован',
                        4 => 'Выполняет задание',
                        5 => 'Отключен'
                    ])
                    ->required(),
                Select::make('user.referral')
                    ->title('У кого в рефералах')
                    ->fromModel(VkUser::class, 'name')
                    ->empty(''),
                Select::make('user.region')
                    ->title('Регион')
                    ->fromModel(Region::class, 'name')
                    ->empty(''),
                TextArea::make('user.params')
                    ->max(255)
                    ->rows(5)
                    ->title('Каждая строка, новый параметр'),
            ])
        ];
    }

    public function update(Request $request, VkUser $user)
    {
        $dataUser = $request->user; //Получаем все данные кнопки
        $user->fill($dataUser)->save();

        Alert::info('Вы успешно изменили пользователя ВК');
        return redirect()->route('user.vk.edit', $user->id);
    }

    public function remove(VkUser $user)
    {
        $user->delete()
            ? Alert::info('Вы успешно удалили пользователя')
            : Alert::warning('Произошла ошибка');

        return redirect()->route('user.vk.list');
    }
}
