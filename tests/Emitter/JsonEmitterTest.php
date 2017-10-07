<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\EmitterOptions;
use CentErr\Emitter\JsonEmitter;
use RuntimeException;

class JsonEmitterTest extends BaseEmitterTestCase
{
    /**
     * @test
     */
    public function it_emits_formatted_exception()
    {
        $emitter = new JsonEmitter(EmitterOptions::createDefault());

        $emitter->emit(new RuntimeException('Something went wrong'));

        $output = $this->getActualOutput();
        $payload = json_decode($output, true);

        $this->assertSame('RuntimeException', $payload['error']['type']);
        $this->assertSame('Something went wrong', $payload['error']['message']);
    }
}
