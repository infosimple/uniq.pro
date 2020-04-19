<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User;

use App\Http\Requests\UserRequest;
use App\Models\Users\Site\SocUser;
use App\Models\Users\Social\IRoles;
use App\Models\Users\Social\Vk\VkUser;
use App\Orchid\Layouts\User\UserEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Orchid\Access\UserSwitch;
use App\Models\Users\Site\User;
use Orchid\Platform\Models\Role;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class UserEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'User';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Details such as name, email and password';

    /**
     * @var string
     */
    public $permission = 'platform.systems.users';

    /**
     * Query data.
     *
     * @param User $user
     *
     * @return array
     */
    public function query(User $user): array
    {
        $user->load(['roles', 'socAccount']);
        return [
            'user' => $user,
            'soc' => $user->socAccount
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
            DropDown::make(__('Settings'))
                ->icon('icon-open')
                ->list([
                    Button::make(__('Login as user'))
                        ->icon('icon-login')
                        ->method('loginAs'),

                    ModalToggle::make(__('Change Password'))
                        ->icon('icon-lock-open')
                        ->method('changePassword')
                        ->modal('password')
                        ->title(__('Change Password')),

                ]),

            Button::make(__('Save'))
                ->icon('icon-check')
                ->method('save'),

            Button::make(__('Remove'))
                ->icon('icon-trash')
                ->confirm('Are you sure you want to delete the user?')
                ->method('remove'),
        ];
    }

    /**
     * @throws \Throwable
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            UserEditLayout::class,

            Layout::modal('password', [
                Layout::rows([
                    Password::make('password')
                        ->placeholder(__('Enter your password'))
                        ->required()
                        ->title(__('Password')),
                ]),
            ]),
        ];
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(User $user, UserRequest $request)
    {
        $data = $request->get('user');
        $soc = $request->get('soc');
        $user->fill($data)->save();
        dd($user->socAccount);
        if(!$user->socAccount){
            $socUser = SocUser::create($soc);
            $user->socAccount()->associate($socUser)->save();
        }else{
            $user->socAccount->fill($soc)->save();
        }

        if($soc['vk_user_id']){
            $userVk = VkUser::find($soc['vk_user_id']);
            switch ($data['roles_id']){
                case Role::getIdRole('moderator'):
                    $userVk->update(['role' => IRoles::MODERATOR]);
                    // ТУТ ОТПРАВКА СООБЩЕНИЯ
                    break;
                case Role::getIdRole('admin'):
                    $userVk->update(['role' => IRoles::ADMIN]);
                    // ТУТ ОТПРАВКА СООБЩЕНИЯ
                    break;
            }
        }


//        if ($data['roles_id'] == Role::getIdRole('moderator')){
//          $actionResponse->sendMessageModerator('Вы успешно добавлены, как модератор в систему UNIQ.pro. Все уведомления будут присылаться сюда.
//          В случае не выполнения задания в течение 5 минут, оно будет передано другому модератору.
//          ');
//        }
//        if ($data['roles_id'] == Role::getIdRole('admin')){
//            $userVk = VkUser::find($data['vk_user_id']);
//            $actionResponse = new Action(
//                new VKApiClient($bot->config['version']), $bot, $userVk
//            );
//            $actionResponse->sendMessageModerator('Вы успешно добавлены, как администратор в систему UNIQ.pro.');
//        }

        Toast::info(__('User was saved.'));

        return redirect()->route('platform.systems.users.edit', $user->id);
    }

    /**
     * @param User $user
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        $user->delete();

        Toast::info(__('User was removed'));

        return redirect()->route('platform.systems.users');
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAs(User $user)
    {
        UserSwitch::loginAs($user);

        return redirect()->route(config('platform.index'));
    }

    /**
     * @param User    $user
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(User $user, Request $request)
    {
        $user->password = Hash::make($request->get('password'));
        $user->save();

        Toast::info(__('User was saved.'));

        return back();
    }
}
