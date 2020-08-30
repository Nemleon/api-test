<?php

namespace App\Models\Api\MiddlewareChain\User;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use App\Models\Api\User;

class ApiAuthorize extends MiddlewareChain
{
    public function handler($params = null)
    {
        $token = auth()->attempt($params);
        if (! $token) {

            $response = new GetResponse();

            return $response->handler(
                [
                    'code' => 401,
                    'message' => [
                        'message' => 'Неверный логин / пароль',
                        'error' => true
                    ]
                ]);

        } else {

            $userInfo = User::getUserInfoByEmail($params['email']);

            return parent::handler(
                [
                    'code' => 200,
                    'message' => [
                        'token' => $token,
                        'userInfo' => $userInfo,
                        'message' => "Вы успешно вошли в систему",
                        'error' => false
                    ]
                ]);

        }
    }
}
