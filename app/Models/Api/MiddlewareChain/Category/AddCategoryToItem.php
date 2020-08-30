<?php

namespace App\Models\Api\MiddlewareChain\Category;

use App\Models\Api\ApiDB;
use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;

class AddCategoryToItem extends MiddlewareChain
{
    public function handler($params = null)
    {
        $category = new ApiDB();
        $result = $category->addCategoryToItem($params);

        switch ($result) {
            case null:
                $response = new GetResponse();
                return $response->handler(
                    [
                        'code' => 400,
                        'message' => [
                            'message' => 'Товару уже присвоена эта категория',
                            'error' => true
                        ]
                    ]);
                break;

            case false :
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
                        'code' => 200,
                        'message' => [
                            'message' => 'Товару успешно присвоена новая категория!',
                            'error' => false
                        ]
                    ]);
                break;
        }
    }
}
