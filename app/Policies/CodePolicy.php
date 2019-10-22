<?php

namespace App\Policies;

use App\User;
use App\Code;

class CodePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the code.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function view(User $user, Code $code)
    {
        return $code->isOwnedBy($user);
    }

    /**
     * Determine whether the user can create codes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the code.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function update(User $user, Code $code)
    {
        return $code->isOwnedBy($user);
    }

    /**
     * Determine whether the user can delete the code.
     *
     * @param  \App\User  $user
     * @param  \App\Code  $code
     * @return mixed
     */
    public function delete(User $user, Code $code)
    {
        return false;
    }

    /**
     * Determine whether the user can vote the code.
     *
     * @param User    $user
     * @param Code $code
     *
     * @return bool
     */
    public function vote(User $user, Code $code)
    {
        return true;
    }
}
