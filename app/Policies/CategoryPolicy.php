<?php

namespace App\Policies;

use App\User;

class CategoryPolicy extends BasePolicy
{
    public function before(User $user, $ability)
    {
        return $user->isAdmin();
    }
}
