<?php

namespace App\Enums;


class AttachmentStatusEnum extends BaseEnum
{
    const NORMAL = 1;//正常
    const HIDE   = 0;//隐藏
    const REPEAT = -1;//重复

    protected static $ATTRS  = [
        self::NORMAL => '正常',
        self::HIDE   => '隐藏',
        self::REPEAT => '重复',
    ];
    protected static $COLORS = [
        self::NORMAL => ColorEnum::SUCCESS,
        self::HIDE   => ColorEnum::INFO,
        self::REPEAT => ColorEnum::DANGER,
    ];
}
