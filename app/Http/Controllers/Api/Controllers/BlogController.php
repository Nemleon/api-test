<?php

namespace App\Http\Controllers\Api\Controllers;

use App\Http\Controllers\Api\Controllers\Controller;
use App\Http\Controllers\Api\Controllers\Validators\BlogApiValidator;
use App\Models\Api\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function getPosts()
    {
        $allPosts = Blog::all();
        return response()->json(['message' => $allPosts], 200);
    }

    public function getPostByTitle($title)
    {
        $params = BlogApiValidator::validUrlParams($title);

        if ($params) {
            $post = Blog::getPostByTitle($params);

            $empty = true;
            foreach ($post as $item) {
                if ($item) {
                    $empty = false;
                }
            }

            if ($empty === false) {
                $response = ['message' => $post];
                $code = 200;
            } else {
                $response = ['error' => true, 'message' => 'Такого поста не существет'];
                $code = 404;
            }
        } else {
            $response = ['error' => true, 'message' => 'Вы не ввели пост для поиска'];
            $code = 400;
        }

        return response()->json($response, $code);
    }

    public function createPost(Request $request)
    {
        $gotItems = BlogApiValidator::validCreateParams($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 400;
        } else {
            $params = $gotItems->validated();

            $author = $this->userInfo['name'];
            $title = $params['title'];
            $post = $params['post'];

            try {
                if (Blog::createPost($author, $post, $title)) {
                    $response = ['message' => "Пост успешно создан"];
                    $code = 201;
                } else {
                    $response = ['error' => true, 'message' => 'Что-то пошло не так'];
                    $code = 400;
                }
            } catch (\Exception $e) {
                $response = ['error' => true, 'message' => 'Ошибочка'];
                $code = 400;
            }
        }

        return response()->json($response, $code);
    }

    public function deletePost(Request $request)
    {
        $gotItems = BlogApiValidator::validDeleteParams($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 400;
        } else {
            $params = $gotItems->validated();

            if ($this->userInfo['role'] !== 'admin' || $params['name'] === $this->userInfo['name']) {

                if (Blog::deletePost($params['post_id'])) {
                    $response = ['message' => 'Пост успешно удалён'];
                    $code = 200;
                } else {
                    $response = ['error' => true, 'message' => 'Такого поста не сущестует'];
                    $code = 404;
                }

            } else {

                $response = ['error' => true, 'message' => 'У Вас недостаточно прав, чтобы удалить этот пост'];
                $code = 403;

            }
        }

        return response()->json($response, $code);
    }

    public function updatePost(Request $request)
    {
        $gotItems = BlogApiValidator::validUpdParams($request);

        if ($gotItems->fails()) {
            $response = ['error' => true, 'message' => $gotItems->errors()];
            $code = 400;
        } else {
            $params = $gotItems->validated();

            if ($this->userInfo['role'] === 'admin' || $params['name'] === $this->userInfo['name']) {

                $postId = ($params['post_id']);

                unset($params['name']);
                unset($params['post_id']);

                if (Blog::updatePost($postId, $params)) {
                    $response = ['message' => 'Пост успешно обновлен'];
                    $code = 200;
                } else {
                    $response = ['error' => true, 'message' => 'Такого поста не существует'];
                    $code = 404;
                }
            } else {
                $response = ['error' => true, 'message' => 'У Вас недостаточно прав, чтобы обновить этот пост'];
                $code = 403;
            }
        }

        return response()->json($response, $code);
    }
}
