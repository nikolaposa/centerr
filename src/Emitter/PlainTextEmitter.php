<?php

declare(strict_types=1);

namespace CentErr\Emitter;

use Throwable;

final class PlainTextEmitter extends AbstractHttpEmitter
{
    protected function format(Throwable $exception) : string
    {
        $text = sprintf(
            '%s: %s',
            get_class($exception),
            $exception->getMessage()
        );

        if ($this->options->includeTrace()) {
            $text .= "\n\n";

            $trace = $exception->getTrace();
            $traceLength = count($trace);

            $text .= "Stacktrace:\n";
            foreach ($trace as $i => $traceRecord) {
                $text .= $this->formatTraceRecord($traceRecord, $i, $traceLength);
                $text .= "\n";
            }
        }

        return $text;
    }

    protected function getContentType() : string
    {
        return 'text/plain';
    }
}
