<?php

namespace Tests\Unit\user;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class UserCreateTest extends TestCase
{
    use DatabaseTransactions;

    const URL = 'api/v1/user/create';

    /**
     * A basic test example.
     * @test
     */
    public function it_can_create_a_new_user(): void
    {
        $user = $this->instanceUser();

        $this->userAuthenticate($user);

        $userToken = $this->createToken($user);

        $requestBody = [
            'name' => fake()->name,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
            'password' => Str::random(10),
            'address' => fake()->address
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $userToken,
            'Accept' => 'application/json',
        ])->post(self::URL, $requestBody);

        $this->assertTrue($response['isSuccessful']);
    }

    /**
     * A basic test example.
     * @test
     */
    public function it_can_attempt_to_create_a_user_without_being_authenticated(): void
    {
        $requestBody = [
            'name' => fake()->name,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
            'password' => Str::random(10),
            'address' => fake()->address
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post(self::URL, $requestBody);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
