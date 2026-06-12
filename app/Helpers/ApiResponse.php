<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function success(string $message, mixed $data = [], int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public static function paginated(ResourceCollection $collection, string $message): JsonResponse
    {
        $resourceData = $collection->response()->getData(true);

        return response()->json(array_filter([
            'success' => true,
            'message' => $message,
            'data'    => $resourceData['data'],
            'meta'    => $resourceData['meta'] ?? null,
            'links'   => $resourceData['links'] ?? null,
        ], fn($value) => $value !== null), Response::HTTP_OK);
    }

    public static function error(string $message, int $code = Response::HTTP_BAD_REQUEST, array $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
