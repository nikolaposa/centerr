<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\EmitterInterface;
use CentErr\Emitter\EmitterOptions;
use CentErr\Emitter\HtmlEmitter;
use RuntimeException;

class HtmlEmitterTest extends HttpEmitterTestCase
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

        $expected = "<h2>An error has occurred</h2>\n<p>Something went wrong</p>";

        $this->assertSame($expected, $this->getActualOutput());
    }

    protected function createEmitter(array $options = []) : EmitterInterface
    {
        return new HtmlEmitter(EmitterOptions::create($options));
    }
}
