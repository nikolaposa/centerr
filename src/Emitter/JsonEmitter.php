<?php

declare(strict_types=1);

namespace CentErr\Emitter;

use Throwable;

final class JsonEmitter extends AbstractHttpEmitter
{
    protected function format(Throwable $exception) : string
    {
        $errorInfo = [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ];

        return json_encode([
            'error' => $errorInfo,
        ], defined('JSON_PARTIAL_OUTPUT_ON_ERROR') ? JSON_PARTIAL_OUTPUT_ON_ERROR : 0);
    }

    protected function getContentType() : string
    {
        return 'application/json';
    }
}
