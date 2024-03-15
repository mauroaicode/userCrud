<?php

namespace Tests\Unit\user;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class UserUpdateTest extends TestCase
{
    use DatabaseTransactions;

    const URL = 'api/v1/user/:userId/update';

    /**
     * A basic test example.
     * @test
     */
    public function it_can_update_user(): void
    {
        $userAuth = $this->instanceUser();

        $this->userAuthenticate($userAuth);

        $userToken = $this->createToken($userAuth);

        $newUser = $this->instanceUser();

        $urlParameters = [
            'userId' => $newUser->id
        ];

        $url = $this->parseUrl(self::URL, $urlParameters);

        $requestBody = [
            'name' => fake()->name,
            'last_name' => fake()->lastName,
            'phone' => fake()->phoneNumber,
            'address' => fake()->address
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $userToken,
            'Accept' => 'application/json',
        ])->put($url, $requestBody);

        $this->assertTrue($response['isSuccessful']);
    }
}
