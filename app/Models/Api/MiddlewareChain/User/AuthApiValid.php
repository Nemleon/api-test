<?php

namespace App\Models\Api\MiddlewareChain\User;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthApiValid extends MiddlewareChain
{
    private $messages = [
        'email.required' => 'Вы не ввели логин',
        'email.email' => 'Введите почтовый адрес',
        'password.required' => 'Вы не ввели пароль',
    ];

    private $rules = [
        'email' => ['required', 'email', 'string'],
        'password' => ['required', 'string']
    ];

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handler($params = null)
    {
        $params = Validator::make($this->request->all(), $this->rules, $this->messages);

        if ($params->fails()) {

            $response = new GetResponse();
            return $response->handler([
                'code' => 400,
                'message' => [
                    'message' => $params->getMessageBag()->toArray(),
                    'error' => true
                ]
            ]);

        } else {

            return parent::handler($params->validated());

        }
    }
}
