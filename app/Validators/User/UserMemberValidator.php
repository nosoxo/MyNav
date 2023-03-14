<?php

namespace App\Validators\User;


use App\Validators\BaseValidator;

class UserMemberValidator extends BaseValidator
{
    protected $rules      = [
        self::RULE_CREATE => [
            'status' => 'required'
        ],
        self::RULE_UPDATE => [
            'status' => 'required'
        ]
    ];
    protected $attributes = [
        'status' => '状态'
    ];
}
