<?php

namespace App\Models\Api\MiddlewareChain\Category;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateCategoryValidator extends MiddlewareChain
{
    private $messages = [
        'name.required' => 'Необходимо ввести название категории',
        'name.max' => 'Длина названия не должна превышать 20 символов',
        'name.string' => 'Название должно быть строкой!',
        'description.required' => 'Поле "Описание" должно быть заполнено',
        'description.string' => 'Описание должно быть строкой!',
        'category_id.required' => 'Поле "ID категории" должно быть заполнено',
        'category_id.integer' => 'ID категории должен быть числом!',
        'category_id.unique' => 'Такая категория уже существует!'
    ];

    private $rules = [
        'name' => ['required', 'max:32', 'string'],
        'description' => ['required', 'string'],
        'category_id' => ['required', 'integer', 'unique:categorys,category_id']
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
