<?php

namespace App\Repositories;

use App\Models\UserInformation;

class UserInformationRepository
{
    public function create(array $data): UserInformation
    {
        return UserInformation::create($data);
    }
}