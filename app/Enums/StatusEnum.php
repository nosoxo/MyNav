<?php

namespace App\Enums;


class StatusEnum extends BaseEnum
{
    const NORMAL = 1;//正常
    const HIDE   = 0;//隐藏

    protected static $ATTRS  = [
        self::NORMAL => '正常',
        self::HIDE   => '隐藏',
    ];
    protected static $COLORS = [
        self::NORMAL => ColorEnum::SUCCESS,
        self::HIDE   => ColorEnum::INFO
    ];
}
