<?php

namespace Tests\Unit\user;

use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserFindTest extends TestCase
{
    const URL = 'api/v1/user/:userId';

    /**
     * A basic test example.
     * @test
     */
    public function it_can_find_users(): void
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
        ])->get($url);

        $this->assertTrue($response['isSuccessful']);
    }

    /**
     * A basic test example.
     * @test
     */
    public function it_can_try_to_find_a_user_with_an_invalid_id(): void
    {
        $userAuth = $this->instanceUser();

        $this->userAuthenticate($userAuth);

        $userToken = $this->createToken($userAuth);

        $urlParameters = [
            'userId' => Str::random(10)
        ];

        $url = $this->parseUrl(self::URL, $urlParameters);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $userToken,
            'Accept' => 'application/json',
        ])->get($url);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
