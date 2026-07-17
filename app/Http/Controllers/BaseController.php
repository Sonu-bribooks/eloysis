<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
     /**
     * Success Response
     */
    protected function success(
        string $message,
        mixed $data=[],
        int $code=200
    ){
        return response()->json([

            'status'=>true,

            'message'=>$message,

            'data'=>$data

        ],$code);
    }

    /**
     * Error Response
     */
    protected function error(
        string $message,
        mixed $errors=[],
        int $code=400
    ){
        return response()->json([

            'status'=>false,

            'message'=>$message,

            'errors'=>$errors

        ],$code);
    }

    /**
     * Validation Error Response
     */

    protected function validationError($errors)
    {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed.',
            'errors' => $errors
        ], 422);
    }
}
