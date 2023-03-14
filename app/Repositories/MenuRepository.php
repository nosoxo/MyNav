<?php
namespace App\Repositories;


use App\Models\Menu;

class MenuRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Menu::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }
}
