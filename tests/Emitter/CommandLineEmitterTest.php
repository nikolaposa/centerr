<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\CommandLineEmitter;
use CentErr\Emitter\EmitterInterface;
use CentErr\Emitter\EmitterOptions;
use RuntimeException;

class CommandLineEmitterTest extends EmitterTestCase
{
    /**
     * @test
     */
    public function it_emits_formatted_exception()
    {
        $emitter = $this->createEmitter([
            'includeTrace' => false,
        ]);

        $emitter->emit(new RuntimeException('Something went wrong'));

        $expected = "+-----------------------+\n| AN ERROR HAS OCCURRED |\n+-----------------------+\nRuntimeException: Something went wrong";

        $this->assertSame($expected, $this->getActualOutput());
    }

    protected function createEmitter(array $options = []) : EmitterInterface
    {
        return new CommandLineEmitter(EmitterOptions::create($options));
    }
}
