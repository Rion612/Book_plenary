<?php


namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponseWithHttpStatus
{
    protected function apiResponse(string $message,$token, $data = null, int $code = Response::HTTP_OK, bool $status = true, $errors = null)
    {
        return response([
            'status' => $status,
            'access_token'=>$token,
            'user' => $data,
            'message' => $message,
            'errors' => $errors
        ], $code);
    }
}
