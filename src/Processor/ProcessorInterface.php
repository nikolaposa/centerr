<?php

declare(strict_types=1);

namespace CentErr\Processor;

use Throwable;

interface ProcessorInterface
{
    public function __invoke(Throwable $exception) : Throwable;
}
