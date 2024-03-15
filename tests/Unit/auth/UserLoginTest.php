<?php

namespace Tests\Unit\auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UserLoginTest extends TestCase
{
    use DatabaseTransactions;

    const URL = 'api/v1/login';

    /**
     * A basic test example.
     * @test
     */
    public function it_can_login_user(): void
    {
        $requestBodyLogin = [
            'email' => config('testing.email_auth'),
            'password' => config('testing.password')
        ];

        $response = $this->post(self::URL, $requestBodyLogin);

        $this->assertTrue($response['isSuccessful']);
    }
}
