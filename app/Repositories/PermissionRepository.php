<?php

namespace App\Repositories;


use App\Models\Permission;

class PermissionRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Permission::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }

}
