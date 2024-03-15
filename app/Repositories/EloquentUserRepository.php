<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repository\UserRepositoryContract;

class EloquentUserRepository implements UserRepositoryContract
{
    public function __construct(
        protected User $model
    )
    {
    }

    /**
     * Gets a collection of all users.
     *
     * @return Collection A collection of User objects.
     */
    public function list(array $columns = ['*']): Collection
    {
        return $this->model->latest()->get($columns);
    }

    /**
     * Save a new user.
     *
     * @param array $user The user's data to save.
     * @return User|null
     */
    public function create(array $user): ?User
    {
        return $this->model->create($user);
    }

    /**
     * Update user.
     *
     * @param string $userId
     * @param array $user The user's data to save.
     * @return User|null
     */
    public function update(string $userId, array $user): ?User
    {
        $userUpdate = $this->findById($userId);

        $userUpdate->update($user);

        return $userUpdate;
    }

    /**
     * Find a user by ID.
     *
     * @param string $userId The ID of the user to search for.
     * @return User|null The User object found or null if not found.
     */
    public function findById(string $userId, array $columns = ['*']): ?User
    {
        return $this->model->byId($userId)->first($columns);
    }

    /**
     * Deletes a user by user ID.
     *
     * @param string $userId The ID of the user to delete.
     * @return void
     */
    public function delete(string $userId): void
    {
        $this->model->byId($userId)->delete();
    }

}
