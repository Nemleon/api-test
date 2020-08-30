<?php

namespace App\Models\Api\MiddlewareChain\Item;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateItemValidator extends MiddlewareChain
{
    private $messages = [
        'item_id.required' => 'Поле "ID товара" должно быть заполнено',
        'item_id.unique' => 'Товар с таким ID уже существует',
        'item_id.integer' => 'ID товара должен быть числом!',
        'name.required' => 'Поле "Название" должно быть заполнено',
        'name.max' => 'Длина названия не должна превышать 20 символов',
        'name.string' => 'Название должно быть строкой!',
        'description.required' => 'Поле "Описание" должно быть заполнено',
        'description.string' => 'Описание должно быть строкой!',
        'category_id.integer' => 'ID категории должен быть числом!',
        'category_id.exists' => 'Такой категории не существует!'
    ];

    private $rules = [
        'item_id' => ['required', 'unique:items,item_id', 'integer'],
        'name' => ['required', 'max:32', 'string'],
        'description' => ['required', 'string'],
        'category_id' => ['integer', 'exists:categorys,category_id']
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

            return parent::handler($params->validated());

        }
    }
}
