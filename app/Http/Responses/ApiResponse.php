<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function response($data): JsonResponse
    {
        return response()
            ->json((object) [
                'data' => $data,
            ]);
    }
}
