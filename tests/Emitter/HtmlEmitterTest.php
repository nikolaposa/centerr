<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use CentErr\Emitter\EmitterOptions;
use CentErr\Emitter\HtmlEmitter;
use RuntimeException;

class HtmlEmitterTest extends BaseEmitterTestCase
{
    /**
     * @test
     */
    public function it_emits_formatted_exception()
    {
        $emitter = new HtmlEmitter(EmitterOptions::create([
            'includeTrace' => false,
        ]));

        $emitter->emit(new RuntimeException('Something went wrong'));

        $expected = "<h2>An error has occurred</h2>\n<p>Something went wrong</p>";

        $this->assertSame($expected, $this->getActualOutput());
    }
}
