<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\EmitterInterface;
use PHPUnit\Framework\TestCase;
use RuntimeException;

abstract class EmitterTestCase extends TestCase
{
    protected function setUp()
    {
        $this->setOutputCallback(function () {
        });
    }

    /**
     * @test
     */
    public function it_emits_exception()
    {
        $emitter = $this->createEmitter();

        $emitter->emit(new RuntimeException('Something went wrong'));

        $this->assertNotEmpty($this->getActualOutput());
    }

    abstract protected function createEmitter(array $options = []) : EmitterInterface;
}
