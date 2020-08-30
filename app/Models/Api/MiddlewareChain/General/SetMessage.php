<?php

namespace App\Models\Api\MiddlewareChain\General;

trait SetMessage
{
    protected function setMessage($message, $code)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
