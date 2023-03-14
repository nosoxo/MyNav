<?php

namespace App\Enums;


class MenuStatusEnum extends BaseEnum
{
    const SHOW = 1;//显示
    const HIDE = 0;//隐藏
    protected static $ATTRS = [
        self::SHOW => '显示',
        self::HIDE => '隐藏'
    ];
    protected static $COLORS = [
        self::SHOW => ColorEnum::SUCCESS,
        self::HIDE   => ColorEnum::INFO
    ];
}
