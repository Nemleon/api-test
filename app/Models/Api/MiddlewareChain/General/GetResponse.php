<?php

namespace App\Models\Api\MiddlewareChain\General;

use App\Models\Api\MiddlewareChain\MiddlewareChain;

class GetResponse extends MiddlewareChain
{
    public function handler($params = null)
    {
        $this->setMessage($params['message'], $params['code']);
        $this->setResponse();

        if (is_array($params['message'])) {

            return $this->response();

        } else {

            return parent::handler();

        }
    }
}
