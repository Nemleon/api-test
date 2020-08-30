<?php


namespace App\Models\Api\MiddlewareChain\Category;


use App\Models\Api\Category;
use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;

class GetAllCategories extends MiddlewareChain
{
    public function handler($params = null)
    {
        $categories = Category::getAllCategories();

        switch ($categories) {
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
                        'message' => $categories,
                        'error' => false
                    ]
                ]);
                break;
        }
    }
}
