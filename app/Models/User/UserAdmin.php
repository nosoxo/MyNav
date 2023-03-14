<?php

namespace App\Models\User;


use App\Models\User;
use App\Traits\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    use DateTimeFormat;
    protected $fillable = ['user_id', 'login_count', 'last_login_at', 'status'];

    public function user ()
    {
        return $this->belongsTo (User::class);
    }
}
