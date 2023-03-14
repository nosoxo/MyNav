<?php

namespace App\Enums;


class UploadDriverEnum extends BaseEnum
{
    const ALIYUN = 'oss';
    const QINIU  = 'kodo';
    protected static $ATTRS = [
        self::ALIYUN => '阿里云OSS',
        self::QINIU  => '七牛云KODO'
    ];
}
