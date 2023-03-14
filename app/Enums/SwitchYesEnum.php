<?php

namespace App\Enums;


class SwitchYesEnum extends BaseEnum
{
    const YES = 1;
    const NO  = 0;
    protected static $ATTRS = [
        self::YES => '是',
        self::NO  => '否'
    ];
}
