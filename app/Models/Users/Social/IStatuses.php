<?php


namespace App\Models\Users\Social;


interface IStatuses
{
    const NOT_ACTIVATE = 0;
    const MODERATION = 1;
    const ACTIVATE = 2;
    const DISABLED = 3;
    const BUSY = 4;
    const FREE = 5;
}
