<?php

namespace App\Http\Controllers\Api\Controllers\Auth;

use App\Http\Controllers\Api\Controllers\Controller;
use App\Http\Controllers\Api\Controllers\Validators\AuthApiValid;
use App\Models\Api\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $gotItems = AuthApiValid::loginParamsValid($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 401;
        } else {
            $params = $gotItems->validated();

            if (!$token = auth()->attempt($params)) {
                $response = ['error' => true, 'message' => 'Неверный логин / пароль'];
                $code = 401;
            } else {
                $userInfo = User::getUserInfoByEmail($params['email']);
                $response = [
                    'token' => $token,
                    'userInfo' => $userInfo,
                    'message' => "Вы успешно вошли в систему"
                ];
                $code = 201;
            }
        }

        return response()->json($response, $code);
    }

    public function register(Request $request)
    {

        $gotItems = AuthApiValid::registerParamsValid($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 401;
        } else {
            $items = $gotItems->validated();

            User::create([
                'name' => $items['name'],
                'email' => $items['email'],
                'password' => Hash::make($items['password']),
                'role' => 'user',
                'about' => 'Расскажите о себе!',
            ]);

            $params = $request->only(['email', 'password']);

            if (!$token = auth()->attempt($params)) {
                $response = ['error' => true, 'message' => 'Что-то пошло не так'];
                $code = 401;
            } else {
                $userInfo = User::getUserInfoByEmail($params['email']);
                $response = [
                    'token' => $token,
                    'userInfo' => $userInfo,
                    'message' => "{$items['name']}, Вы успешно зарегистрировались и вошли в систему"
                ];
                $code = 201;
            }
        }

        return response()->json($response, $code);
    }
}
