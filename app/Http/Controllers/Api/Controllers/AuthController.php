<?php

namespace App\Http\Controllers\Api\Controllers;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\User\ApiAuthorize;
use App\Models\Api\MiddlewareChain\User\ApiRegistration;
use App\Models\Api\MiddlewareChain\User\AuthApiValid;
use App\Models\Api\MiddlewareChain\User\RegisterApiValid;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $auth = new AuthApiValid($request);
        $auth->linkWith(new ApiAuthorize())
            ->linkWith(new GetResponse());

        $response = $auth->handler();

        return response()->json($response['message'], $response['code']);
    }

    public function registration(Request $request)
    {
        $auth = new RegisterApiValid($request);
        $auth->linkWith(new ApiRegistration())
            ->linkWith(new GetResponse());

        $response = $auth->handler();

        return response()->json($response['message'], $response['code']);
    }
}
