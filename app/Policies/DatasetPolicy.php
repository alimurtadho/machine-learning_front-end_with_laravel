<?php

namespace App\Policies;

use App\User;
use App\Dataset;

class DatasetPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the dataset.
     *
     * @param  User  $user
     * @param  Dataset  $dataset
     * @return bool
     */
    public function view(User $user, Dataset $dataset)
    {
        return $dataset->isOwnedBy($user);
    }

    /**
     * Determine whether the user can create datasets.
     *
     * @param  User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the dataset.
     *
     * @param  User  $user
     * @param  Dataset  $dataset
     * @return bool
     */
    public function update(User $user, Dataset $dataset)
    {
        return $dataset->isOwnedBy($user);
    }

    /**
     * Determine whether the user can delete the dataset.
     *
     * @param  User  $user
     * @param  Dataset  $dataset
     * @return bool
     */
    public function delete(User $user, Dataset $dataset)
    {
        return false;
    }

    /**
     * Determine whether the user can add code to the dataset.
     *
     * @param User    $user
     * @param Dataset $dataset
     *
     * @return bool
     */
    public function addCode(User $user, Dataset $dataset)
    {
        return $dataset->isPublished();
    }

    /**
     * Determine whether the user can upload files.
     *
     * @param User    $user
     * @param Dataset $dataset
     *
     * @return bool
     */
    public function uploadFile(User $user, Dataset $dataset)
    {
        return $dataset->isOwnedBy($user);
    }

    /**
     * Determine whether the user can publish and un-publish datasets.
     *
     * @param User    $user
     * @param Dataset $dataset
     *
     * @return bool
     */
    public function publish(User $user, Dataset $dataset)
    {
        return false;
    }

    /**
     * Determine whether the user can feature and remove featured datasets.
     *
     * @param User    $user
     * @param Dataset $dataset
     *
     * @return bool
     */
    public function feature(User $user, Dataset $dataset)
    {
        return false;
    }

    /**
     * Determine whether the user can vote the dataset.
     *
     * @param User    $user
     * @param Dataset $dataset
     *
     * @return bool
     */
    public function vote(User $user, Dataset $dataset)
    {
        return true;
    }
}
