<?php

namespace App\Handlers\API\V1;

class SessionHandler
{
    public function handleSessionResponse(object $user, string $token): object
    {
        return (object)[
            'access_token' => $token,
            'user' => $user
        ];
    }
}
