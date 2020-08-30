<?php

namespace App\Models\Api\MiddlewareChain\Item;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateItemValidator extends MiddlewareChain
{
    private $messages = [
        'item_id.required' => 'Необходимо ввести ID товара',
        'item_id.exists' => 'Невозможно обновить - товара с таким ID не существует',
        'description.string' => 'Описание не может быть пустым!',
        'name.string' => 'Название не может быть пустым!',
        'name.max' => 'Длина названия не должна превышать 32 символа'
    ];

    private $rules = [
        'item_id' => ['required', 'exists:items,item_id'],
        'description' => ['string'],
        'name' => ['string', 'max:32']
    ];

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function  handler($params = null)
    {
        $params = Validator::make($this->request->all(), $this->rules, $this->messages);



        if ($params->fails()) {

            $response = new GetResponse();
            return $response->handler([
                'code' => 400,
                'message' => [
                    'message' => $params->getMessageBag()->toArray(),
                    'error' => true
                ]
            ]);

        } else {
            $itemId = '';
            $param = [];
            $array = $params->validated();

            foreach ($array as $key => $value) {
                if ($key === 'item_id') {
                    $itemId = $value;
                } else {
                    $param[$key] = $value;
                }
            }

            return parent::handler(['item_id' => $itemId, 'params' => $param]);

        }
    }
}
