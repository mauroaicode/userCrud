<?php

namespace Tests;

use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function userAuthenticate(User $user): void
    {
        Passport::actingAs($user);
    }

    public function createToken(User $user): string
    {
        return $user->createToken('TestToken')->accessToken;
    }

    public function instanceUser(): User
    {
        return User::factory()->create();
    }

    /**
     * Generate a dynamic URL by replacing placeholders in the base URL with provided parameters.
     *
     * @param string $baseUrl - Base URL containing placeholders (e.g., :key) to be replaced
     * @param array $parameters - Array of parameters to replace placeholders in the URL
     * @return string - Generated dynamic URL
     */
    public function parseUrl(string $baseUrl, array $parameters): string
    {
        $search = array_map(function ($key) {
            return ':' . $key;
        }, array_keys($parameters));
        $replace = array_values($parameters);

        return str_replace($search, $replace, $baseUrl);
    }
}
