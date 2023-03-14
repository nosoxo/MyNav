<?php

namespace App\Repositories;


use App\Models\Article;

class ArticleRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Article::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }
}
