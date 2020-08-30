<?php

namespace App\Models\Api\MiddlewareChain\User;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use App\Models\Api\User;
use Illuminate\Support\Facades\Hash;

class ApiRegistration extends MiddlewareChain
{
    public function handler($params = null)
    {
        try {

            User::create(['name' => $params['name'], 'email' => $params['email'], 'password' => Hash::make($params['password'])]);

            return parent::handler([
                'code' => 201,
                'message' => [
                    'message' => "Вы успешно зарегестрировались и можете войти в систему!",
                    'error' => false
                ]
            ]);

        } catch (\Exception $e) {

            $response = new GetResponse();

            return $response->handler([
                'code' => 500,
                'message' => [
                    'message' => 'Что-то пошло не так, попробуйте позже :С',
                    'error' => true
                ]
            ]);

        }
    }
}
