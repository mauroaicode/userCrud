<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Handlers\API\V1\ResponseHttpHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="UserCrudTest Documentation - Tests Design Solutions", version="0.1")
 */
class AppBaseController extends Controller
{
    /**
     * Responds with a successful JSON response structure.
     *
     * @param mixed $data The data to include in the response.
     * @param int $code (Optional) The HTTP response code. By default, it is 200 (OK).
     * @return JsonResponse The successful JSON response with the provided data.
     */
    public function sendSuccess(mixed $data, int $code = Response::HTTP_OK): JsonResponse
    {
        return ResponseHttpHandler::sendSuccess($data, $code);
    }

    /**
     * Responds with an error JSON response structure.
     *
     * @param string $message The error message to include in the response.
     * @param int $code (Optional) The HTTP response code. By default, it is 404 (Not Found).
     * @return JsonResponse The error JSON response with the provided message.
     */
    public function sendError(string $message, mixed $code = Response::HTTP_NOT_FOUND): JsonResponse
    {
        return ResponseHttpHandler::sendError($message, $code);
    }
}
