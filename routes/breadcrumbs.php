<?php

declare(strict_types=1);

use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Models\Bot\Bot;

//Screens

// Platform > System > Users
Breadcrumbs::for('platform.systems.users', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Users'), route('platform.systems.users'));
});

// Platform > System > Users > User
Breadcrumbs::for('platform.systems.users.edit', function (BreadcrumbsGenerator $trail, $user) {
    $trail->parent('platform.systems.users');
    $trail->push(__('Edit'), route('platform.systems.users.edit', $user));
});

// Platform > System > Roles
Breadcrumbs::for('platform.systems.roles', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.systems.index');
    $trail->push(__('Roles'), route('platform.systems.roles'));
});

// Platform > System > Roles > Create
Breadcrumbs::for('platform.systems.roles.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.systems.roles');
    $trail->push(__('Create'), route('platform.systems.roles.create'));
});

// Platform > System > Roles > Role
Breadcrumbs::for('platform.systems.roles.edit', function (BreadcrumbsGenerator $trail, $role) {
    $trail->parent('platform.systems.roles');
    $trail->push(__('Role'), route('platform.systems.roles.edit', $role));
});

// Platform -> Example Screen
Breadcrumbs::for('platform.example', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push(__('Example screen'));
});

// Platform -> Example Fields
Breadcrumbs::for('platform.example.fields', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push(__('Form controls'));
});

// Platform -> Example Layouts
Breadcrumbs::for('platform.example.layouts', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push(__('Overview layouts'));
});

// Bots
Breadcrumbs::for('bots.list', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push(__('Боты'), route('bots.list'));
});

// Bot Vk
Breadcrumbs::for('bot.vk.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('bots.list');
    $trail->push(__('Создание бота в ВК'), route('bot.vk.create'));
});

// Bot Telegram
Breadcrumbs::for('bot.telegram.create', function (BreadcrumbsGenerator $trail) {
    $trail->parent('bots.list');
    $trail->push(__('Создание бота в Telegrame'), route('bot.telegram.create'));
});

// Bot Edit Vk
Breadcrumbs::for('bot.vk.edit', function (BreadcrumbsGenerator $trail, $bot) {
    $trail->parent('bots.list');
    $trail->push(__('Редактирование Вк бота'), route('bot.vk.edit', $bot));
});

// Bot Edit Telegram
Breadcrumbs::for('bot.telegram.edit', function (BreadcrumbsGenerator $trail, $bot) {
    $trail->parent('bots.list');
    $trail->push(__('Редактирование Telegram бота'), route('bot.telegram.edit', $bot));
});

// Bot Button List
Breadcrumbs::for('bot.button.list', function (BreadcrumbsGenerator $trail, $bot) {
    $trail->parent('bots.list');
    $trail->push(__('Кнопки бота'), route('bot.button.list', $bot));
});

// Bot Button Create/Update
Breadcrumbs::for('bot.button.edit', function (BreadcrumbsGenerator $trail, $bot, $id = null) {
    $msg = 'Создание кнопки';
    if ($id) {
        $msg = 'Изменение кнопки';
    }
    $trail->parent('bot.button.list', $bot);
    $trail->push(__($msg), route('bot.button.edit', $bot));
});

// Bot KeyBoard List
Breadcrumbs::for('bot.keyboard.list', function (BreadcrumbsGenerator $trail, $bot) {
    $trail->parent('bots.list');
    $trail->push(__('Клавиатуры бота'), route('bot.keyboard.list', $bot));
});

// Bot KeyBoard Create/Update
Breadcrumbs::for('bot.keyboard.edit', function (BreadcrumbsGenerator $trail, $bot, $id = null) {
    $msg = 'Создание клавиатуры';
    if ($id) {
        $msg = 'Изменение клавиатуры';
    }
    $trail->parent('bot.keyboard.list', $bot);
    $trail->push(__($msg), route('bot.keyboard.edit', $bot));
});

// Bot Messages List
Breadcrumbs::for('bot.message.list', function (BreadcrumbsGenerator $trail, $bot) {
    $trail->parent('bots.list');
    $trail->push(__('Сообщения бота'), route('bot.message.list', $bot));
});

// Bot Messages Create/Update
Breadcrumbs::for('bot.message.edit', function (BreadcrumbsGenerator $trail, $bot, $id = null) {
    $msg = 'Создание сообщения';
    if ($id) {
        $msg = 'Изменение сообщения';
    }
    $trail->parent('bot.message.list', $bot);
    $trail->push(__($msg), route('bot.message.edit', $bot));
});

// Bot EventMessages List
Breadcrumbs::for('bot.eventMessage.list', function (BreadcrumbsGenerator $trail, $bot) {
    $trail->parent('bots.list');
    $trail->push(__('Событийные сообщения бота'), route('bot.eventMessage.list', $bot));
});

// Bot EventMessages Create/Update
Breadcrumbs::for('bot.eventMessage.edit', function (BreadcrumbsGenerator $trail, $bot, $id = null) {
    $msg = 'Создание событийного сообщения';
    if ($id) {
        $msg = 'Изменение событийного сообщения';
    }
    $trail->parent('bot.eventMessage.list', $bot);
    $trail->push(__($msg), route('bot.eventMessage.edit', $bot));
});

// Bot MessageGroup List
Breadcrumbs::for('bot.messagegroup.list', function (BreadcrumbsGenerator $trail, $bot) {
    $trail->parent('bots.list');
    $trail->push(__('Группы сообщений бота'), route('bot.messagegroup.list', $bot));
});

// Bot MessageGroup Create/Update
Breadcrumbs::for('bot.messagegroup.edit', function (BreadcrumbsGenerator $trail, $bot, $id = null) {
    $msg = 'Создание группы собщений';
    if ($id) {
        $msg = 'Изменение группы сообщений';
    }
    $trail->parent('bot.messagegroup.list', $bot);
    $trail->push(__($msg), route('bot.messagegroup.edit', $bot));
});

// Users Vk List
Breadcrumbs::for('user.vk.list', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push('Пользователи VK', route('user.vk.list'));
});

// Users Vk Create/Update
Breadcrumbs::for('user.vk.edit', function (BreadcrumbsGenerator $trail, $id) {
    $trail->parent('user.vk.list');
    $trail->push('Пользователь', route('user.vk.edit', $id));
});

// Moderation List
Breadcrumbs::for('moderation.list', function (BreadcrumbsGenerator $trail) {
    $trail->parent('platform.index');
    $trail->push('Список задач', route('moderation.list'));
});

// Moderation execute
Breadcrumbs::for('moderation.edit', function (BreadcrumbsGenerator $trail, $id) {
    $trail->parent('moderation.list');
    $trail->push('Задача', route('moderation.edit', $id));
});
