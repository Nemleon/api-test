<?php

namespace App\Http\Controllers\Api\Controllers\Validators;

use App\Http\Controllers\Api\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserApiValidator extends Controller
{
    static public function validUrlParams($param)
    {
        return htmlentities(trim($param));
    }

    static public function validCreateParams(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['string'],
            'about' => ['string'],
        ];

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
        ];

        return $validatedItems = Validator::make($request->all(), $rules, $messages);
    }

    static public function validName(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'exists:users']
        ];

        $messages = [
            'name.required' => 'Вы не ввели имя',
            'name.exists' => 'Пользователь не найден'
        ];

        return $validatedItems = Validator::make($request->all(), $rules, $messages);
    }

    static public function validUpdParams(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'exists:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:8'],
            'role' => ['string'],
            'about' => ['string'],
        ];

        $messages = [
            'name.required' => 'Вы не ввели имя',
            'name.exists' => 'Пользователь не найден',
            'email.email' => 'Заполните поле почта в формате Email',
            'email.max' => 'Введено слишком много  символов (макс. 255)',
            'email.unique' => 'Введенная почта уже занята',
            'password.min' => 'Введено недостаточное кол-во символов (мин. 8)',
            'password.string' => 'Вы не ввели пароль',
            'about.string' => 'Вы не заполнили информацию "о себе"',
            'role.string' => 'Вы не ввели роль',
        ];

        return $validatedItems = Validator::make($request->all(), $rules, $messages);
    }
}
