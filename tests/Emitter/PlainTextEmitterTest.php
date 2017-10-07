<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\EmitterOptions;
use CentErr\Emitter\PlainTextEmitter;
use RuntimeException;

class PlainTextEmitterTest extends BaseEmitterTestCase
{
    /**
     * @test
     */
    public function it_emits_formatted_exception()
    {
        $emitter = new PlainTextEmitter(EmitterOptions::create([
            'includeTrace' => false,
        ]));

        $emitter->emit(new RuntimeException('Something went wrong'));

        $expected = 'RuntimeException: Something went wrong';

        $this->assertSame($expected, $this->getActualOutput());
    }
}
