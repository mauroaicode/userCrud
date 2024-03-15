<?php

namespace App\Contracts\Repository;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthRepositoryContract
{
    /**
     * Authenticate the user using the credentials provided.
     *
     * @param array $credentials The user's credentials (e.g. email and password).
     * @return bool Returns true if authentication is successful, otherwise returns false.
     */
    public function authenticate(array $credentials): bool;

    /**
     * Checks if a user is currently authenticated.
     *
     * @return bool Returns true if the user is authenticated, otherwise returns false.
     */
    public function checkUserAuthenticated(): bool;

    /**
     * Create an access token for the authenticated user.
     *
     * @return string The generated access token.
     */
    public function createToken(): string;

    /**
     * Gets the currently authenticated user.
     *
     * @return Authenticatable The User of the authenticated user.
     */
    public function getAuthUser(): Authenticatable;

    /**
     * Logs out the currently authenticated user.
     *
     * @return void
     */
    public function logout(): void;
}
