<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use PHPUnit\Framework\TestCase;

abstract class BaseEmitterTestCase extends TestCase
{
    protected function setUp()
    {
        $this->setOutputCallback(function () {
        });
    }
}
