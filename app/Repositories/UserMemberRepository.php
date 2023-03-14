<?php

namespace App\Repositories;


use App\Models\User\UserMember;
use App\Validators\User\UserMemberValidator;

class UserMemberRepository extends BaseRepository implements InterfaceRepository
{

    public function model ()
    {
        return UserMember::class;
    }

    public function validator ()
    {
        return UserMemberValidator::class;
    }

    public function allowDelete ($id)
    {
        return true;
    }

}
