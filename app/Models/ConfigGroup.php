<?php

namespace App\Models;


use App\Traits\DateTimeFormat;
use Illuminate\Database\Eloquent\Model;

class ConfigGroup extends Model
{
    use DateTimeFormat;
    protected $fillable = ['name', 'title'];

    public static function insertGroup ($name, $title)
    {
        $name  = strtolower (trim ($name));
        $group = ConfigGroup::updateOrCreate ([
            'name' => $name
        ], [
            'name'  => $name,
            'title' => $title
        ]);

        return $group->id;
    }
}
