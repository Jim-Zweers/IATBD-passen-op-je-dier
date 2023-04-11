<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PolicyForPet
{
    // Policy example
    public function update(User $user, Pet $pet){
        return $user->id === $pet->owner_id; // $user->role === Role::Owner;
    }

    public function store(User $user){
        return $user->role === Role::Owner;
    }


}
