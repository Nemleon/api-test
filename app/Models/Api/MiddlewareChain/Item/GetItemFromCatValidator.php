<?php

namespace App\Models\Api\MiddlewareChain\Item;

use App\Models\Api\MiddlewareChain\General\GetResponse;
use App\Models\Api\MiddlewareChain\MiddlewareChain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GetItemFromCatValidator extends MiddlewareChain
{
    private $messages = [
        'category_id.required' => 'Необходимо внести ID категории',
        'category_id.exists' => 'Категории с таким ID не существует'
    ];

    private $rules = [
        'category_id' =>  ['required', 'exists:categorys,category_id']
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
                'code' => 404,
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
