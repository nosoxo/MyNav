<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['user_id', 'name', 'title', 'cover_id', 'desc', 'content', 'status'];
}
