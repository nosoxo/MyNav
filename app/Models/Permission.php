<?php

namespace App\Models;


use App\Traits\DateTimeFormat;

class Permission extends \Spatie\Permission\Models\Permission
{
    use DateTimeFormat;
}
