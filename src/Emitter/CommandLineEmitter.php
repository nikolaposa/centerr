<?php

declare(strict_types=1);

namespace CentErr\Emitter;

use Throwable;

final class CommandLineEmitter extends AbstractEmitter
{
    protected function format(Throwable $exception) : string
    {
        $headerText = ' AN ERROR HAS OCCURRED ';
        $border = str_repeat('-', strlen($headerText));

        $output = "+$border+\n|$headerText|\n+$border+\n";

        $output .= sprintf(
            '%s: %s',
            get_class($exception),
            $exception->getMessage()
        );

        if ($this->options['includeTrace']) {
            $output .= "\n\n";

            $trace = $exception->getTrace();
            $traceLength = count($trace);

            $output .= "Stacktrace:\n";
            foreach ($trace as $i => $traceRecord) {
                $output .= $this->formatTraceRecord($traceRecord, $i, $traceLength);
                $output .= "\n";
            }
        }

        return $output;
    }
}
