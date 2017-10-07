<?php

declare(strict_types=1);

namespace CentErr\Emitter;

use Throwable;

abstract class AbstractHttpEmitter extends AbstractEmitter
{
    public function emit(Throwable $exception) : void
    {
        $this->sendHeaders();

        parent::emit($exception);
    }

    protected function sendHeaders() : void
    {
        if (!isset($_SERVER["REQUEST_URI"]) || headers_sent()) {
            return;
        }

        http_response_code(500);

        header("Content-Type: {$this->getContentType()}");
    }

    abstract protected function getContentType() : string;
}
