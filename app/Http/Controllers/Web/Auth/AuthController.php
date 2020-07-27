<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\Web\GetApiInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function apiAuth(Request $request)
    {
        $data = GetApiInfo::getItems($request);
        $content = json_decode($data['content'], true, JSON_UNESCAPED_UNICODE);

        if (!isset($content['error'])) {
            $authCookie = json_encode($content['userInfo'][0]);
            $tokenCookie = json_encode($content['token']);

            return response()->view(
                'auth.uarelogin',
                ['content' => $content['message']],
                $data['code'])
                ->cookie('auth', $authCookie, 60)
                ->cookie('bearer_token', $tokenCookie, 60);
        } else {
            return redirect()->back()->with(['err' => $content['message']]);
        }
    }

    public function apiLogout()
    {
        $auth = Cookie::forget('auth');
        $token = Cookie::forget('bearer_token');

        return response()->view(
            'auth.uarelogin',
            ['content' => 'Вы вышли из аккаунта'],
            200)
            ->withCookie($auth)
            ->withCookie($token);
    }
}
