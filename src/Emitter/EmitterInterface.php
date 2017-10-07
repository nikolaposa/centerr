<?php

declare(strict_types=1);

namespace CentErr\Emitter;

use Throwable;

interface EmitterInterface
{
    public function emit(Throwable $exception) : void;
}
