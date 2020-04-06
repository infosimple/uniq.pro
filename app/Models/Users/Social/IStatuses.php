<?php


namespace App\Models\Users\Social;


interface IStatuses
{
    const STATUS_NOT_ACTIVATE = 0;
    const STATUS_MODERATION = 1;
    const STATUS_ACTIVATE = 2;
    const STATUS_DISABLED = 3;
}
