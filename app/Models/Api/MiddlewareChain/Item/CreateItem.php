<?php

namespace App\Models\Api\MiddlewareChain\Item;

use App\Models\Api\ApiDB;
use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;

class CreateItem extends MiddlewareChain
{
    public function handler($params = null)
    {
        $item = new ApiDB();
        $result = $item->createItem($params);

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
                            'message' => 'Товар успешно создан!',
                            'error' => false
                        ]
                    ]);
                break;
        }
    }
}
