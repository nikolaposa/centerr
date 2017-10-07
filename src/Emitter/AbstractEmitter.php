<?php

declare(strict_types=1);

namespace CentErr\Emitter;

use Throwable;

abstract class AbstractEmitter implements EmitterInterface
{
    /**
     * @var EmitterOptions
     */
    protected $options;

    public function __construct(EmitterOptions $options)
    {
        $this->options = $options;
    }

    public function emit(Throwable $exception) : void
    {
        ob_start();
        $output = $this->format($exception);
        ob_end_clean();

        echo $output;
    }

    abstract protected function format(Throwable $exception) : string;

    final protected function formatTraceRecord(array $traceRecord, int $index, int $traceLength) : string
    {
        return sprintf(
            '#%s %s%s%s in %s:%s',
            $traceLength - $index - 1,
            $traceRecord['class'] ?? '',
            isset($traceRecord['class'], $traceRecord['function']) ? ':' : '',
            $traceRecord['function'] ?? '',
            $traceRecord['file'] ?? 'unknown',
            $traceRecord['line'] ?? 0
        );
    }
}
