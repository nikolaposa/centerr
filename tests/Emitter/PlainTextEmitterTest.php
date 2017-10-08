<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\EmitterInterface;
use CentErr\Emitter\PlainTextEmitter;
use RuntimeException;

class PlainTextEmitterTest extends HttpEmitterTestCase
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

        $expected = 'RuntimeException: Something went wrong';

        $this->assertSame($expected, $this->getActualOutput());
    }

    protected function createEmitter(array $options = []) : EmitterInterface
    {
        return new PlainTextEmitter($options);
    }
}
