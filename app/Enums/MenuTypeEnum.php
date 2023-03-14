<?php

namespace App\Enums;


class MenuTypeEnum extends BaseEnum
{
    const MENU = 1;//菜单
    const BTN  = 2;//按钮
    protected static $ATTRS = [
        self::MENU => '菜单',
        self::BTN  => '按钮'
    ];
    protected static $COLORS = [
        self::MENU => ColorEnum::PRIMARY,
        self::BTN   => ColorEnum::SECONDARY
    ];
}
