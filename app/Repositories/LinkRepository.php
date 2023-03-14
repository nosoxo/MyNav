<?php
namespace App\Repositories;


use App\Models\Link;

class LinkRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Link::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }
}
