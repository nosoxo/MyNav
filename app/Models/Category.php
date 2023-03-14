<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    /**
     * 可以批量赋值的属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sort',
        'flag',
        'description'
    ];
    /**
     *  隐藏属性
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
