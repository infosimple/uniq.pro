<?php

namespace App\Orchid\Screens\Bot\Vk\Users;

use App\Models\Site\Region;
use App\Models\Users\Social\IRoles;
use App\Models\Users\Social\IStatuses;
use App\Models\Users\Social\Vk\VkUser;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class VkUserEditScreen extends Screen
{

    public $name = 'Изменение пользователя';
    public $description = '';
    protected $params;

    public function query(VkUser $user): array
    {
        if ($user->params) {
            foreach ($user->params as $key => $value) {
                $this->params .= "$key: $value\n";
            }
            $user->params = $this->params;
        }

        $user->load(['region', 'invite'])->get();
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
                Select::make('user.role')
                    ->title('Роль пользователя')
                    ->options([
                        IRoles::USER => 'Неизвестный',
                        IRoles::CLICKER => 'Кликер',
                        IRoles::MODERATOR => 'Модератор',
                        IRoles::ADMIN => 'Админ'
                    ])
                    ->required(),
                Select::make('user.status')
                    ->title('Статус пользователя')
                    ->options([
                        IStatuses::NOT_ACTIVATE => 'Не активирован',
                        IStatuses::MODERATION => 'На модерации',
                        IStatuses::ACTIVATE => 'Активирован',
                        IStatuses::DISABLED => 'Отключен'
                    ])
                    ->required(),
                Relation::make('user.referral')
                    ->fromModel(VkUser::class, 'vk_id')
                    ->displayAppend('name')
                    ->title('У кого в рефералах'),
                Select::make('user.region_id')
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

    public function update(VkUser $user, Request $request)
    {

        $dataUser = $request->user; //Получаем все данные кнопки
        unset($dataUser['params']);
        $user->update($dataUser);

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
