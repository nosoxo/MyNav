<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    /**
     * 可以批量赋值的属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'url',
        'sort',
        'flag',
        'description',
    ];
    /**
     * 默认属性值
     *
     * @var false[]
     */
    protected $attributes = [
        'click' => 0,
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
