<?php

declare(strict_types=1);

namespace CentErr;

interface ErrorHandlerInterface
{
    public function register() : void;

    public function unregister() : void;
}
