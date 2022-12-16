<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function responseErrorJson($error)
    {
        return response()->json([
            'error' => true,
            'message' => $error
        ]);
    }

    protected function responseSuccessJson($message)
    {
        return response()->json([
            'error' => false,
            'message' => $message
        ]);
    }
}
