<?php

namespace App\Contracts\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryContract
{
    /**
     * Gets a collection of all users.
     *
     * @return Collection A collection of User objects.
     */
    public function list(): Collection;

    /**
     * Save a new user.
     *
     * @param array $user The user's data to save.
     * @return User|null
     */
    public function create(array $user): ?User;

    /**
     * Update a user.
     *
     * @param string $userId
     * @param array $user The user's data to save.
     * @return User|null
     */
    public function update(string $userId, array $user): ?User;

    /**
     * Find a user by ID.
     *
     * @param string $userId The ID of the user to search for.
     * @return User|null The User object found or null if not found.
     */
    public function findById(string $userId): ?User;

    /**
     * Deletes a user by user ID.
     *
     * @param string $userId The ID of the user to delete.
     * @return void
     */
    public function delete(string $userId): void;
}
