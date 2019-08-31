<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    protected function noContent()
    {
        return response()->json(null, 204);
    }

    protected function error($message, $statusCode)
    {
        $data = [
            'error' => [
                'message' => $message,
                'error_code' => $statusCode,
            ]
        ];
        return response()->json($data, $statusCode);
    }

    protected function errorNotFound($message = 'Not Found')
    {
        return $this->error($message, 404);
    }

    protected function errorBadRequest($message = 'Bad Request')
    {
        return $this->error($message, 400);
    }

    protected function errorForbidden($message = 'Forbidden')
    {
        return $this->error($message, 403);
    }

    protected function errorInternal($message = 'Internal Error')
    {
        return $this->error($message, 500);
    }

    protected function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->error($message, 401);
    }

    protected function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        return $this->error($message, 405);
    }
}
