<?php

namespace App\Http\Controllers\API\V1\User;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\API\V1\User\{
    UserFindAPIRequest,
    UserCreateAPIRequest,
    UserUpdateAPIRequest
};
use App\Http\Controllers\API\V1\AppBaseController;
use App\Contracts\Repository\UserRepositoryContract;


class UserAPIController extends AppBaseController
{
    protected array $columns = [
        'id',
        'name',
        'last_name',
        'email',
        'phone',
        'state',
        'address',
        'path_profile_photo',
        'created_at'
    ];

    public function __construct(
        private UserRepositoryContract $repository
    )
    {
    }

    /**
     * Build Request From Parameters
     *
     * @return array The parameters retrieved from the request.
     */
    private function getParams(): array
    {
        return request()->only('name', 'last_name', 'email', 'phone', 'address', 'path_profile_photo0', 'password');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/user/list",
     *      summary="Gets all users",
     *      tags={"User"},
     *      description="Gets all users",
     *      security={ {"passport": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/GetUsersResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/ErrorResponse")
     *      ),
     * )
     *
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        return rescue(function () {

            $users = $this->repository->list($this->columns);

            $message = 'Ok';

            return $this->sendSuccess(compact('message', 'users'));

        }, function ($e) {

            return $this->sendError($e->getMessage(), $e->getCode()); // @codeCoverageIgnore
        });
    }

    /**
     * @OA\Post(
     *      path="/api/v1/user/create",
     *      summary="Create User",
     *      tags={"User"},
     *      description="Create a new user",
     *      security={ {"passport": {} }},
     *      @OA\RequestBody(
     *         description="Create a new user body",
     *         required=true,
     *         @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/CreateUserBodySchema")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/GetUserResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/ErrorResponse")
     *      ),
     * )
     *
     * @param UserCreateAPIRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function createUser(UserCreateAPIRequest $request): JsonResponse
    {
        $data = $this->getParams();

        return rescue(function () use ($data) {

            DB::beginTransaction();

            $user = $this->repository->create($data);

            DB::commit();

            $message = 'Ok';

            return $this->sendSuccess(compact('message', 'user'));

        }, function ($e) {

            DB::rollBack(); // @codeCoverageIgnore

            return $this->sendError($e->getMessage(), $e->getCode()); // @codeCoverageIgnore
        });
    }


    /**
     * @OA\Put(
     *      path="/api/v1/user/{userId}/update",
     *      summary="Update User",
     *      tags={"User"},
     *      description="Update a new user",
     *      security={ {"passport": {} }},
     *      @OA\Parameter(ref="/swagger/swagger.yml#/components/parameters/User/userId"),
     *      @OA\RequestBody(
     *         description="Update a new user body",
     *         required=true,
     *         @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/UpdateUserBodySchema")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/GetUserResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/ErrorResponse")
     *      ),
     * )
     *
     * @param UserUpdateAPIRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function updateUser(UserUpdateAPIRequest $request): JsonResponse
    {
        $data = $this->getParams();
        $userId = $request->input('userId');

        return rescue(function () use ($userId, $data) {

            DB::beginTransaction();

            $user = $this->repository->update($userId, $data);

            DB::commit();

            $message = 'Ok';

            return $this->sendSuccess(compact('message', 'user'));

        }, function ($e) {

            DB::rollBack(); // @codeCoverageIgnore
            return $this->sendError($e->getMessage(), $e->getCode()); // @codeCoverageIgnore
        });
    }

    /**
     * @OA\Get(
     *      path="/api/v1/user/{userId}",
     *      summary="Find a user by its ID",
     *      tags={"User"},
     *      description="Find a user by its ID.",
     *      security={ {"passport": {} }},
     *      @OA\Parameter(ref="/swagger/swagger.yml#/components/parameters/User/userId"),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/GetUserResponseSchema")
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error operation",
     *          @OA\JsonContent(ref="/swagger/swagger.yml#/components/schemas/ErrorResponse")
     *      ),
     * )
     *
     * @param UserFindAPIRequest $request
     * @return JsonResponse
     * @throws Exception If the user does not exist.
     */
    public function findUser(UserFindAPIRequest $request): JsonResponse
    {
        $userId = $request->input('userId');

        return rescue(function () use ($userId) {

            $user = $this->repository->findById($userId, $this->columns);

            $message = 'Ok';

            return $this->sendSuccess(compact('message', 'user'));

        }, function ($e) {

            return $this->sendError($e->getMessage(), $e->getCode()); // @codeCoverageIgnore
        });
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/user/{userId}/delete",
     *      summary="Delete a user by its ID",
     *      tags={"User"},
     *      description="Delete a user by its ID",
     *      security={ {"passport": {} }},
     *      @OA\Parameter(ref="/swagger/swagger.yml#/components/parameters/User/userId"),
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
     * @param UserFindAPIRequest $request
     * @return JsonResponse
     * @throws Exception If the user does not exist.
     */
    public function deleteUser(UserFindAPIRequest $request): JsonResponse
    {
        $userId = $request->input('userId');

        return rescue(function () use ($userId) {

            $this->repository->delete($userId);

            $message = 'Ok';

            return $this->sendSuccess(compact('message'));

        }, function ($e) {

            return $this->sendError($e->getMessage(), $e->getCode()); // @codeCoverageIgnore
        });
    }
}
