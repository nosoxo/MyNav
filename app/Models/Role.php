<?php

namespace App\Models;


use App\Traits\DateTimeFormat;

class Role extends \Spatie\Permission\Models\Role
{
    use DateTimeFormat;
}
