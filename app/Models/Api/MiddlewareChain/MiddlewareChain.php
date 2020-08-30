<?php

namespace App\Models\Api\MiddlewareChain;

use App\Models\Api\MiddlewareChain\General\SetMessage;
use App\Models\Api\MiddlewareChain\General\SetResponse;

abstract class MiddlewareChain
{
    use SetResponse;
    use SetMessage;

    private $nextLink;

    private $response;

    private $message;
    private $code;

    public function message()
    {
        return $this->message;
    }

    public function code()
    {
        return $this->code;
    }

    public function response()
    {
        return $this->response;
    }

    public function linkWith(MiddlewareChain $nextLink)
    {
        $this->nextLink = $nextLink;
        return $nextLink;
    }

    public function handler($params = null)
    {
        if (! $this->nextLink) {
            return $this->response();
        }

        return $this->nextLink->handler($params);
    }
}
