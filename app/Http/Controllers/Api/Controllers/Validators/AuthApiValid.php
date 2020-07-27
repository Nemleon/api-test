<?php


namespace App\Http\Controllers\Api\Controllers\Validators;

use App\Http\Controllers\Api\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthApiValid extends Controller
{
    static public function registerParamsValid(Request $request)
    {
        $messages = [
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

        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

    static public function loginParamsValid(Request $request)
    {
        $rules = [
            'email' => ['required', 'email', 'string'],
            'password' => ['required', 'string']
        ];

        $messages = [
            'email.required' => 'Вы не ввели логин',
            'email.email' => 'Введите почтовый адрес',
            'password.required' => 'Вы не ввели пароль',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }

}
