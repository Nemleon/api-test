<?php

namespace App\Models\Api\MiddlewareChain\User;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterApiValid extends MiddlewareChain
{
    private $messages = [
        'name.required' => 'Не введено имя',
        'name.string' => 'Поле Имя не может быть пустым',
        'name.max' => 'Введено слишком много  символов (макс. 255)',
        'name.unique' => 'Пользователь с таким именем уже существует',
        'email.required' => 'Не введена почта',
        'email.string' => 'Поле Почта не может быть пустым',
        'email.email' => 'Заполните поле почта в формате Email',
        'email.max' => 'Введено слишком много  символов (макс. 255)',
        'email.unique' => 'Пользователь с такой почтой уже существует',
        'password.required' => 'Не введен пароль',
        'password.string' => 'Поле Пароль не может быть пустым',
        'password.min' => 'Введено недостаточное кол-во символов (мин. 8)',
        'password.confirmed' => 'Пароли не совпадают',
    ];

    private $rules = [
        'name' => ['required', 'string', 'max:255', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
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
