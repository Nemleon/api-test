<?php

namespace App\Models\Api\MiddlewareChain\General;

trait SetResponse
{
    protected function setResponse()
    {
        $this->response = ['message' => $this->message, 'code' => $this->code];
    }
}
