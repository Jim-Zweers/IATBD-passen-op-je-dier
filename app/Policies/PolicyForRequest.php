<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class PolicyForRequest
{
    public function store(User $user){
        return $user->role === Role::Owner;
    }
}
