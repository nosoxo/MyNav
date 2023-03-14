<?php
namespace App\Repositories;


use App\Models\Log;
use Illuminate\Database\Eloquent\Model;

class LogRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Log::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }
}
