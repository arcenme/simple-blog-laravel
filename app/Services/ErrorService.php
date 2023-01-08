<?php

namespace App\Services;

class ErrorService
{
    public static function returnJson($errorCode, $message)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $errorCode);
    }
}
