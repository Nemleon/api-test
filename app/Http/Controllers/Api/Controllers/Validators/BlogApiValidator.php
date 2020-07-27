<?php

namespace App\Http\Controllers\Api\Controllers\Validators;

use App\Http\Controllers\Api\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BlogApiValidator extends Controller
{
    static public function validUrlParams($param)
    {
        return htmlentities(trim($param));
    }

    static public function validCreateParams(Request $request)
    {
        $rules = [
            'title' => ['required', 'string', 'unique:blogs'],
            'post' => ['required', 'string'],
        ];

        $message = [
            'title.unique' => 'Статья с таким заголовком уже существет. Придумайте другой!',
            'title.required' => 'Укажите заголовок',
            'post' => 'Напишите текст',
        ];

        return Validator::make($request->all(), $rules, $message);
    }

    static function validDeleteParams(Request $request)
    {
        $rules = [
            'name' => ['required','string', 'exists:users'],
            'post_id' => ['required', 'string', 'exists:blogs'],
        ];

        $message = [
            'name.required' => 'Введите имя автора',
            'name.exists' => 'Такого автора не существует',
            'post_id.required' => 'Введите ID поста',
            'post_id.exists' => 'Такого поста не существует',
        ];

        return Validator::make($request->all(), $rules, $message);
    }

    static function validUpdParams(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'exists:users'],
            'post_id' => ['required', 'string', 'exists:blogs'],
            'post' => ['string'],
            'title' => ['string'],
        ];

        $message = [
            'name.required' => 'Введите имя автора',
            'name.exists' => 'Такого автора не существует',
            'post_id.required' => 'Введите ID поста',
            'post_id.exists' => 'Такого поста не существует',
            'post.string' => 'Вы не ввели текст',
            'title.string' => 'Вы не ввели заголовок',
        ];

        return Validator::make($request->all(), $rules, $message);
    }
}

