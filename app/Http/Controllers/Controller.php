<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    protected function buildFailedValidationResponse(Request $request, array $errors) {
        return response()->json([
            'status' => 'error',
            'message' => 'The data is failed to validate',
            'errors' => $errors
        ], 422);
    }
}
