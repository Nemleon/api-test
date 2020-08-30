<?php

namespace App\Models\Api\MiddlewareChain\Category;

use App\Models\Api\Category;
use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;

class CreateCategory extends MiddlewareChain
{
    public function handler($params = null)
    {
        $result = Category::createCategory($params);

        switch ($result) {
            case false:
                $response = new GetResponse();
                return $response->handler(
                    [
                        'code' => 500,
                        'message' => [
                            'message' => 'Что-то пошло не так, попробуте еще раз!',
                            'error' => true
                        ]
                    ]);
                break;

            default :
                return parent::handler(
                    [
                        'code' => 201,
                        'message' => [
                            'message' => 'Категория успешно создана!',
                            'error' => false
                        ]
                    ]);
                break;
        }
    }
}
