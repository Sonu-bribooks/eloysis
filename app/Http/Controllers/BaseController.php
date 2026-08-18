<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseController extends Controller
{
    /**
     * Success Response
     */
    protected function success(
        string $message,
        mixed $data = [],
        int $code = 200
    ) {
        return response()->json([

            'status' => true,

            'message' => $message,

            'data' => $data,

        ], $code);
    }

    /**
     * Error Response
     */
    protected function error(
        string $message,
        mixed $errors = [],
        int $code = 400
    ) {
        return response()->json([

            'status' => false,

            'message' => $message,

            'errors' => $errors,

        ], $code);
    }

    /**
     * Validation Error Response
     */
    protected function validationError($errors)
    {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => $errors,
        ], 422);
    }

    /**
     * DataTables-compatible JSON response.
     */
    protected function datatable(
        mixed $result,
        int $draw = 1
    ): JsonResponse {
        if ($result instanceof LengthAwarePaginator) {
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $result->total(),
                'recordsFiltered' => $result->total(),
                'data' => $result->items(),
            ]);
        }

        if (is_array($result)) {
            $data = $result['data'] ?? $result;
            $recordsTotal = $result['recordsTotal'] ?? count($data);
            $recordsFiltered = $result['recordsFiltered'] ?? count($data);

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => is_array($data) ? array_values($data) : $data,
            ]);
        }

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
        ]);
    }
}
