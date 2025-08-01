<?php

namespace App\Managers;

use App\Models\User;
use App\Data\UserData;

class UserManager
{
    public static function updateUser(User $user, UserData $data): void
    {
        $user->first_name = $data->first_name;
        $user->last_name = $data->last_name;
        $user->email = $data->email;
        $user->phone = $data->phone;
        $user->save();
    }
}

