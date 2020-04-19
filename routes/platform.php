<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\Bot\BotsScreen;
use App\Orchid\Screens\Bot\Vk\BotEditScreen as VkBotEditScreen;
use App\Orchid\Screens\Bot\Telegram\BotEditScreen as TelegramBotEditScreen;
use App\Orchid\Screens\Bot\Button\ButtonListScreen;
use App\Orchid\Screens\Bot\Button\ButtonEditScreen;
use App\Orchid\Screens\Bot\KeyBoard\KeyBoardListScreen;
use App\Orchid\Screens\Bot\KeyBoard\KeyBoardEditScreen;
use App\Orchid\Screens\Bot\Message\MessageListScreen;
use App\Orchid\Screens\Bot\Message\MessageEditScreen;
use App\Orchid\Screens\Bot\EventMessage\EventMessageListScreen;
use App\Orchid\Screens\Bot\EventMessage\EventMessageEditScreen;
use App\Orchid\Screens\Bot\MessageGroup\MessageGroupListScreen;
use App\Orchid\Screens\Bot\MessageGroup\MessageGroupEditScreen;
use App\Orchid\Screens\Bot\Vk\Users\VkUserEditScreen;
use App\Orchid\Screens\Bot\Vk\Users\VkUserListScreen;
use App\Orchid\Screens\Site\Moderation\ModerationEditScreen;
use App\Orchid\Screens\Site\Moderation\ModerationListScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
$this->router->screen('/main', PlatformScreen::class)->name('platform.main');

// Users...
$this->router->screen('users/{users}/edit', UserEditScreen::class)->name('platform.systems.users.edit');
$this->router->screen('users', UserListScreen::class)->name('platform.systems.users');

// Roles...
$this->router->screen('roles/{roles}/edit', RoleEditScreen::class)->name('platform.systems.roles.edit');
$this->router->screen('roles/create', RoleEditScreen::class)->name('platform.systems.roles.create');
$this->router->screen('roles', RoleListScreen::class)->name('platform.systems.roles');

// Example...
$this->router->screen('example', ExampleScreen::class)->name('platform.example');
$this->router->screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
$this->router->screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');

// Bot...
$this->router->screen('bots', BotsScreen::class)->name('bots.list');

// Button
$this->router->screen('bot/{bot}/buttons', ButtonListScreen::class)->name('bot.button.list');
$this->router->screen('bot/{bot}/button/{id?}', ButtonEditScreen::class)->name('bot.button.edit');

// KeyBoard
$this->router->screen('bot/{bot}/keyboards', KeyBoardListScreen::class)->name('bot.keyboard.list');
$this->router->screen('bot/{bot}/keyboard/{id?}', KeyBoardEditScreen::class)->name('bot.keyboard.edit');

// Message
$this->router->screen('bot/{bot}/messages', MessageListScreen::class)->name('bot.message.list');
$this->router->screen('bot/{bot}/message/{id?}', MessageEditScreen::class)->name('bot.message.edit');

// EventMessage
$this->router->screen('bot/{bot}/event-messages', EventMessageListScreen::class)->name('bot.eventMessage.list');
$this->router->screen('bot/{bot}/event-message/{id?}', EventMessageEditScreen::class)->name('bot.eventMessage.edit');

// MessageGroup
$this->router->screen('bot/{bot}/messagegroups', MessageGroupListScreen::class)->name('bot.messagegroup.list');
$this->router->screen('bot/{bot}/messagegroup/{id?}', MessageGroupEditScreen::class)->name('bot.messagegroup.edit');

$this->router->screen('bot/vk/{bot}', VkBotEditScreen::class)->name('bot.vk.edit');
$this->router->screen('bot/vk', VkBotEditScreen::class)->name('bot.vk.create');

$this->router->screen('vk/user/{id}', VkUserEditScreen::class)->name('user.vk.edit');
$this->router->screen('vk/users', VkUserListScreen::class)->name('user.vk.list');

// Moderation Tasks
$this->router->screen('moderation/task/{id}', ModerationEditScreen::class)->name('moderation.edit');
$this->router->screen('moderation/tasks', ModerationListScreen::class)->name('moderation.list');


$this->router->screen('bot/telegram/{bot}', TelegramBotEditScreen::class)->name('bot.telegram.edit');
$this->router->screen('bot/telegram', TelegramBotEditScreen::class)->name('bot.telegram.create');

$this->router->screen('telegram/user/{id}', TelegramUserEditScreen::class)->name('user.telegram.edit');
$this->router->screen('telegram/users', TelegramUserListScreen::class)->name('user.telegram.list');






