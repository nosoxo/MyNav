<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

interface InterfaceRepository
{
    public function model ();

    public function validator ();

    public function allowDelete ($id);
}
