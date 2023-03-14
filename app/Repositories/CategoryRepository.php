<?php
namespace App\Repositories;


use App\Models\Category;

class CategoryRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Category::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }
}
