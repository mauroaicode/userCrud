<?php

namespace Tests\Unit\auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UserLogoutTest extends TestCase
{
    const URL_LOGIN = 'api/v1/login';
    const URL = 'api/v1/logout';


    /**
     * A basic test example.
     * @test
     */
    public function it_can_logout_user(): void
    {
        $requestBodyLogin = [
            'email' => config('testing.email_auth'),
            'password' => config('testing.password')
        ];

        $responseLogin = $this->post(self::URL_LOGIN, $requestBodyLogin);

        $userToken = $responseLogin['session']['access_token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $userToken,
            'Accept' => 'application/json',
        ])->post(self::URL);

        $this->assertTrue($response['isSuccessful']);
    }
}
