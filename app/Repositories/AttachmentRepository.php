<?php

namespace App\Repositories;


use App\Models\Attachment;

class AttachmentRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return Attachment::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }
}
