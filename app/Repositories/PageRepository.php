<?php

namespace App\Repositories;


use App\Models\Page;

class PageRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Page::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }
}
