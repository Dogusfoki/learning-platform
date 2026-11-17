<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function create(User $user): bool
    {
        return $user->email === 'john@example.com';
    }
    public function edit(User $user, User $model): boolval
    {
        return (bool) random_int(0, 1);
    }

    public function __construct()
    {



    }

}
