<?php

namespace App\Enums;


class UserStatusEnum extends BaseEnum
{
    const ENABLE  = 1;
    const DISABLE = 2;
    protected static $ATTRS = [
        self::ENABLE  => '启用',
        self::DISABLE => '禁用'
    ];
}
