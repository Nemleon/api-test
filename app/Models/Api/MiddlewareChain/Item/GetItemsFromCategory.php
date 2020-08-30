<?php

namespace App\Models\Api\MiddlewareChain\Item;

use App\Models\Api\ApiDB;
use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;

class GetItemsFromCategory extends MiddlewareChain
{
    public function handler($params = null)
    {
        $item = new ApiDB();
        $result = $item->getItemsFromCategory($params);

        switch ($result->toArray()) {
            case [] :
                $response = new GetResponse();

                return $response->handler(
                    [
                        'code' => 204,
                        'message' => [
                            'message' => 'В данной категории нет товаров!',
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
                            'message' => [
                                'items' => $result
                            ],
                            'error' => false
                        ]
                    ]);
                break;

        }

    }
}
