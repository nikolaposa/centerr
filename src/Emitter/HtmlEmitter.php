<?php

declare(strict_types=1);

namespace CentErr\Emitter;

use Throwable;

final class HtmlEmitter extends AbstractHttpEmitter
{
    protected function format(Throwable $exception) : string
    {
        $html = '<h2>An error has occurred</h2>';
        $html .= "\n";
        $html .= $this->doFormat($exception);

        return $html;
    }

    private function doFormat(Throwable $exception)
    {
        $html = '<p>' . $exception->getMessage() . '</p>';

        if ($this->options->includeTrace()) {
            $html .= "\n";
            $html .= '<strong>Trace:</strong><br>';
            $html .= "\n";

            $trace = $exception->getTrace();
            $traceLength = count($trace);

            foreach ($exception->getTrace() as $i => $traceRecord) {
                $html .= "\n";
                $html .= $this->formatTraceRecord($traceRecord, $i, $traceLength) . '<br>';
            }
        }

        if ($previous = $exception->getPrevious()) {
            $html .= "\n";
            $html .= '<br><strong>Previous:</strong><br>';
            $html .= "\n";
            $html .= $this->doFormat($previous);
        }

        return $html;
    }

    protected function getContentType() : string
    {
        return 'text/html';
    }
}
