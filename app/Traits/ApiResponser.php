<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

trait ApiResponser
{
    private function successResponse($data, $code): JsonResponse
    {
        return response()->json($data, $code);
    }

    protected function infoResponse($message, $code): JsonResponse
    {
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection|SupportCollection $collection, $code = 200): JsonResponse
    {
        return $this->successResponse(['data' => $collection], $code);
    }

    protected function showOne(Model $instance, $code = 200): JsonResponse
    {
        return $this->successResponse($instance, $code);
    }
}
