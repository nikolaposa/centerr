<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\CommandLineEmitter;
use CentErr\Emitter\EmitterOptions;
use RuntimeException;

class CommandLineEmitterTest extends BaseEmitterTestCase
{
    /**
     * @test
     */
    public function it_emits_formatted_exception()
    {
        $emitter = new CommandLineEmitter(EmitterOptions::create([
            'includeTrace' => false,
        ]));

        $emitter->emit(new RuntimeException('Something went wrong'));

        $expected = "+-----------------------+\n| AN ERROR HAS OCCURRED |\n+-----------------------+\nRuntimeException: Something went wrong";

        $this->assertSame($expected, $this->getActualOutput());
    }
}
