<?php

namespace App\Http\Controllers\Api\Controllers;

use App\Http\Controllers\Api\Controllers\Validators\UserApiValidator;
use App\Http\Controllers\Api\Controllers\Controller;
use App\Models\Api\Blog;
use App\Models\Api\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getUsers()
    {
        $allUsers = User::getAllUsers();
        return response()->json(['message' => $allUsers], 200);
    }

    public function getUserByName($name)
    {
        $validate = UserApiValidator::validUrlParams($name);
        $response = [];

        if ($validate) {
            $userInfo = User::getUserInfo($validate);

            $emptyInfo = true;
            foreach ($userInfo as $item) {
                if ($item) {
                    $emptyInfo = false;
                }
            }

            if ($emptyInfo === false) {

                $posts = Blog::getPostsByAuthor($validate);

                $emptyPosts = true;
                foreach ($posts as $item) {
                    if ($item) {
                        $emptyPosts = false;
                    }
                }

                if ($emptyPosts === false) {
                    $response += [
                        'message' => [
                            'user info' => $userInfo,
                            'user posts' => $posts
                        ]
                    ];
                    $code = 200;
                } else {
                    $response += [
                        'message' => [
                            'user info' => $userInfo,
                            'user posts' => 'Пользователь еще не создавал постов'
                        ]
                    ];
                    $code = 200;
                }
            } else {
                $response = ['error' => true, 'message' => 'Такого пользователя не существует'];
                $code = 404;
            }

        } else {
            $response = ['error' => true, 'message' => 'Вы не ввели имя пользователя'];
            $code = 400;
        }

        return response()->json($response, $code);
    }

    public function createUser(Request $request)
    {
        $gotItems = UserApiValidator::validCreateParams($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 400;
        } else {
            $params = $gotItems->validated();

            if ($this->userInfo['role'] !== 'admin') {
                $response = ['error' => true, 'message' => 'Недостаточно прав'];
                $code = 403;
            } else {
                try {
                    if (User::createUser($params)) {
                        $response = ['message' => "Пользователь {$params['name']} успешно создан"];
                        $code = 201;
                    } else {
                        $response = ['error' => true, 'message' => 'Что-то пошло не так'];
                        $code = 400;
                    }
                } catch (\Exception $e) {
                    $response = ['error' => true, 'message' => "Пользователь {$params['name']} уже существует"];
                    $code = 404;
                }
            }
        }

        return response()->json($response, $code);
    }

    public function deleteUser(Request $request)
    {
        $gotItems = UserApiValidator::validName($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 400;
        } else {
            $params = $gotItems->validated();

            if ($this->userInfo['role'] === 'admin' || $this->userInfo['name'] === $params['name']) {
                if (User::deleteUser($params['name'])) {
                    $response = ['message' => "Пользователь {$params['name']} удалён"];
                    $code = 200;
                } else {
                    $response = ['error' => true, 'message' => "Пользователь {$params['name']} не найден"];
                    $code = 404;
                }
            } else {
                $response = ['error' => true, 'message' => 'Недостаточно прав'];
                $code = 403;
            }
        }

        return response()->json($response, $code);
    }

    public function updateUser(Request $request)
    {
        $gotItems = UserApiValidator::validUpdParams($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 400;
        } else {
            $params = $gotItems->validated();

            if ($this->userInfo['role'] === 'admin' || $this->userInfo['name'] === $params['name']) {

                $itemsToUpd = [];
                foreach ($params as $key => $value) {
                    if ($key !== 'name' && $key !== 'role') {
                        $itemsToUpd += [$key => $value];
                    }

                    if ($key === 'role') {
                        if ($this->userInfo['role'] === 'admin') {
                            $itemsToUpd += [$key => $value];
                        } else {
                            return response()->json(['error' => true, 'message' => 'Недостаточно прав менять роли'], 401);
                        }
                    }
                }

                if (User::updateUser($params['name'], $itemsToUpd)) {
                    $response = ['message' => 'Обновление информации прошло успешно'];
                    $code = 201;
                } else {
                    $response = ['message' => 'Что-то пошло не так. Попробуйте еще раз'];
                    $code = 400;
                }

            } else {

                $response = ['error' => true, 'message' => 'У вас нет прав, для совершения этого действия'];
                $code = 403;

            }
        }

        return response()->json($response, $code);
    }
}
