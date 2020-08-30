<?php

namespace App\Models\Api\MiddlewareChain\Item;

use App\Models\Api\Item;
use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;

class UpdateItem extends MiddlewareChain
{
    public function handler($params = null)
    {
        $result = Item::updateItem($params['item_id'], $params['params']);

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
                            'message' => 'Товар успешно обновлен!',
                            'error' => false
                        ]
                    ]);
                break;
        }
    }
}
