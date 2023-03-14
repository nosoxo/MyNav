<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebView extends Model
{
    public    $timestamps = false;
    protected $fillable   = ['web_user','referer', 'view_url', 'client_ip', 'user_agent', 'view_at'];
}
