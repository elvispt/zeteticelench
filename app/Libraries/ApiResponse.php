<?php

namespace App\Libraries;

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
