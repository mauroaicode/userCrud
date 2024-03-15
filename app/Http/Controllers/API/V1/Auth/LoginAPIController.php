<?php

namespace App\Http\Controllers\API\V1\Auth;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Handlers\API\V1\SessionHandler;
use App\Http\Requests\API\V1\Auth\LoginAPIRequest;
use App\Http\Controllers\API\V1\AppBaseController;
use App\Contracts\Repository\AuthRepositoryContract;

class LoginAPIController extends AppBaseController
{
    public function __construct(
        private SessionHandler         $sessionHandler,
        private AuthRepositoryContract $authRepository

    ){}

    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      summary="Handle Login",
     *      tags={"Auth"},
     *      description="Create a new sessión",
     *      @OA\RequestBody(
     *         description="Create a new sessión body",
     *         required=true,
     *         @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/LoginBodySchema")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/LoginResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/ErrorResponse")
     *      ),
     * )
     *
     * @param LoginAPIRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginAPIRequest $request): JsonResponse
    {
        return rescue(function () use ($request) {

            $credentials = $request->only('email', 'password');

            $isAuthenticate = $this->authRepository->authenticate($credentials);

            if (!$isAuthenticate) {
                throw new Exception(__('auth.failed'), 401);
            }

            $userToken = $this->authRepository->createToken();

            $userAuth = $this->authRepository->getAuthUser();

            $session = $this->sessionHandler->handleSessionResponse($userAuth, $userToken);

            $message = 'Ok';

            return $this->sendSuccess(compact('message', 'session'));

        }, function ($e) {

            return $this->sendError($e->getMessage(), $e->getCode());
        });
    }

    /**
     * @OA\Post(
     *      path="/api/v1/logout",
     *      summary="Handle user logout",
     *      tags={"Auth"},
     *      description="Logout Sessión",
     *      security={ {"passport": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/SuccessResponse")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/ErrorResponse")
     *      ),
     * )
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function logout(): JsonResponse
    {
        return rescue(function () {

            $isCheckUserAuthenticate = $this->authRepository->checkUserAuthenticated();

            if (!$isCheckUserAuthenticate) {

                throw new Exception(__('auth.session_not_active'), 401);
            }

            $this->authRepository->logout();

            $message = 'Ok';

            return $this->sendSuccess(compact('message'));

        }, function ($e) {

            return $this->sendError($e->getMessage(), $e->getCode());
        });
    }
}
