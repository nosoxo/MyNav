<?php

namespace App\Models\User;


use App\Traits\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserInfo
 * @package App\Models\User
 */
class UserInfo extends Model
{
    use DateTimeFormat;
    protected $fillable = ['user_id', 'real_name', 'gender', 'telephone', 'address'];
}
