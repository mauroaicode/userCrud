<?php

namespace Tests\Unit\user;

use Tests\TestCase;

class UserDeleteTest extends TestCase
{
    const URL = 'api/v1/user/:userId/delete';

    /**
     * A basic test example.
     * @test
     */
    public function it_can_delete_users(): void
    {
        $userAuth = $this->instanceUser();

        $this->userAuthenticate($userAuth);

        $userToken = $this->createToken($userAuth);

        $newUser = $this->instanceUser();

        $urlParameters = [
            'userId' => $newUser->id
        ];

        $url = $this->parseUrl(self::URL, $urlParameters);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $userToken,
            'Accept' => 'application/json',
        ])->delete($url);

        $this->assertTrue($response['isSuccessful']);
    }
}
