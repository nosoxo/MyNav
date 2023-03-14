<?php

namespace App\Enums;


class SexEnum extends BaseEnum
{
    const ZERO   = 0;//未知
    const MALE   = 1;//男
    const FEMALE = 2;//女

    protected static $ATTRS = [
        self::MALE   => '男',
        self::FEMALE => '女',
        self::ZERO   => '保密',
    ];
}
