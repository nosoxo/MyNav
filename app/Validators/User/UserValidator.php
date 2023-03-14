<?php

namespace App\Validators\User;


use App\Validators\BaseValidator;

class UserValidator extends BaseValidator
{
    protected $rules      = [
        self::RULE_CREATE => [
            'name'     => 'required',
            'password' => 'required',
        ],
        self::RULE_UPDATE => [
            'name' => 'required',
        ]
    ];
    protected $attributes = [
        'name'     => '登录账号',
        'password' => '登录密码',
    ];
    protected $messages   = [
        'password.required' => '创建新账号需要设置密码'
    ];
}
