<?php

namespace Tests\Unit\user;

use Tests\TestCase;

class UserListTest extends TestCase
{
    const URL = 'api/v1/user/list';

    /**
     * A basic test example.
     * @test
     */
    public function it_can_list_the_users(): void
    {
        $user = $this->instanceUser();

        $this->userAuthenticate($user);

        $userToken = $this->createToken($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $userToken,
            'Accept' => 'application/json',
        ])->get(self::URL);

        $this->assertTrue($response['isSuccessful']);
    }
}
