<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\EmitterInterface;
use CentErr\Emitter\JsonEmitter;
use RuntimeException;

class JsonEmitterTest extends HttpEmitterTestCase
{
    /**
     * @test
     */
    public function it_emits_formatted_exception()
    {
        $emitter = $this->createEmitter();

        $emitter->emit(new RuntimeException('Something went wrong'));

        $output = $this->getActualOutput();
        $payload = json_decode($output, true);

        $this->assertSame('RuntimeException', $payload['error']['type']);
        $this->assertSame('Something went wrong', $payload['error']['message']);
    }

    protected function createEmitter(array $options = []) : EmitterInterface
    {
        return new JsonEmitter($options);
    }
}
