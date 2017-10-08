<?php

declare(strict_types=1);

namespace CentErr\Tests\Emitter;

use RuntimeException;

abstract class HttpEmitterTestCase extends EmitterTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $_SERVER['REQUEST_URI'] = '/test';
    }

    protected function tearDown()
    {
        parent::tearDown();

        unset($_SERVER['REQUEST_URI']);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function it_sets_http_response_code()
    {
        $emitter = $this->createEmitter();

        $emitter->emit(new RuntimeException('Something went wrong'));

        $this->assertSame(500, http_response_code());
    }
}
