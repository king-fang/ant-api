<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ApiController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function error($message = '', $code = 422)
    {
        return response()->json(['code' => $code, 'message' => $message], $code);
    }

    protected function success($data, $code = 200)
    {
        $data = is_array($data) || is_object($data) ? $data : ['message' => $data];
        return response()->json(['code' => $code,'data' => $data], 200);
    }
}
