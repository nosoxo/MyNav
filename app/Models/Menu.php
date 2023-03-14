<?php

namespace App\Models;

use App\Traits\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use DateTimeFormat;
    protected $fillable = ['pid', 'uuid', 'type', 'title', 'auth_name', 'href', 'icon', 'target', 'is_shortcut', 'status', 'sort'];

    public function pidMenu ()
    {
        return $this->belongsTo (Menu::class, 'pid');
    }
}
