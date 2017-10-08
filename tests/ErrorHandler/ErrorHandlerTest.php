<?php

declare(strict_types=1);

namespace CentErr\Tests\ErrorHandler;

use CentErr\Emitter\EmitterInterface;
use CentErr\Emitter\PlainTextEmitter;
use CentErr\ErrorHandler;
use CentErr\Processor\ProcessorInterface;
use ErrorException;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ErrorHandlerTest extends TestCase
{
    /**
     * @test
     */
    public function it_registers_custom_handlers()
    {
        /* @var $emitter EmitterInterface */
        $emitter = $this->createMock(EmitterInterface::class);
        $errorHandler = new ErrorHandler($emitter);

        $errorHandler->register();

        $this->assertTrue($errorHandler->isRegistered());

        $errorHandler->unregister();
    }

    /**
     * @test
     */
    public function it_unregisters_custom_handlers()
    {
        /* @var $emitter EmitterInterface */
        $emitter = $this->createMock(EmitterInterface::class);
        $errorHandler = new ErrorHandler($emitter);

        $errorHandler->register();
        $errorHandler->unregister();

        $this->assertFalse($errorHandler->isRegistered());
    }

    /**
     * @test
     */
    public function it_emits_exception()
    {
        $exception = new RuntimeException('Test emitting');
        $emitter = $this->createMock(EmitterInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter);

        $emitter->expects($this->once())
            ->method('emit')
            ->with($exception);

        $errorHandler->handleException($exception);
    }

    /**
     * @test
     */
    public function it_processes_exception()
    {
        $exception = new RuntimeException('Test processing');
        $emitter = $this->createMock(EmitterInterface::class);
        $processor = $this->createMock(ProcessorInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter, [
            $processor,
        ]);

        $emitter->expects($this->once())
            ->method('emit');
        $processor->method('__invoke')
            ->with($exception)
            ->willReturn($exception);

        $errorHandler->handleException($exception);
    }

    /**
     * @test
     */
    public function it_doesnt_handle_suppressed_errors()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter);

        $errorHandler->register();

        $emitter->expects($this->never())
            ->method('emit');

        @trigger_error('Test error suppression');

        $errorHandler->unregister();
    }

    /**
     * @test
     */
    public function it_doesnt_handle_catched_errors()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter);

        $errorHandler->register();

        $emitter->expects($this->never())
            ->method('emit');

        try {
            trigger_error('Test catching errors');
        } catch (ErrorException $ex) {
        }

        $errorHandler->unregister();

        $this->assertTrue(true); //Program execution continued
    }

    /**
     * @test
     */
    public function it_respects_error_reporting_level()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter);

        $errorHandler->register();

        $emitter->expects($this->never())
            ->method('emit');

        $previousLevel = error_reporting(E_ALL ^ E_USER_NOTICE);
        trigger_error('Test error reporting', E_USER_NOTICE);
        error_reporting($previousLevel);

        $errorHandler->unregister();

        $this->assertTrue(true); //Program execution continued
    }

    /**
     * @test
     */
    public function it_doesnt_affect_getting_silenced_errors()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter);

        $errorHandler->register();

        @ file_get_contents('non-existing-file.txt');

        $error = error_get_last();
        $this->assertInternalType('array', $error);
        $this->assertContains('file_get_contents', $error['message']);

        $errorHandler->unregister();
    }

    /**
     * @test
     */
    public function it_wraps_error_into_exception()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter);

        try {
            $errorHandler->handleError(E_WARNING, 'Test error wrapping', 'file', 100);
        } catch (ErrorException $ex) {
            $this->assertSame('Test error wrapping', $ex->getMessage());
            $this->assertSame(0, $ex->getCode());
            $this->assertSame(E_WARNING, $ex->getSeverity());
            $this->assertSame('file', $ex->getFile());
            $this->assertSame(100, $ex->getLine());
        }
    }

    /**
     * @test
     */
    public function it_gracefully_handle_errors_if_blocking_errors_option_is_disabled()
    {
        $emitter = $this->createMock(EmitterInterface::class);
        /** @noinspection PhpParamsInspection */
        $errorHandler = new ErrorHandler($emitter, [], [
            'blockingErrors' => false,
        ]);

        $emitter->expects($this->once())
            ->method('emit')
            ->with($this->isInstanceOf(ErrorException::class));

        $errorHandler->handleError(E_WARNING, 'Test graceful error handling', 'file', 100);

        $this->assertTrue(true); //Program execution continued
    }

    /**
     * @test
     */
    public function it_sends_emitted_output()
    {
        $errorHandler = new ErrorHandler(
            new PlainTextEmitter([
                'includeTrace' => false,
            ])
        );

        ob_start();
        $errorHandler->handleException(new RuntimeException('Testing output'));
        $this->assertSame('RuntimeException: Testing output', ob_get_clean());
    }

    /**
     * @test
     */
    public function it_handles_fatal_errors_on_shutdown()
    {
    }
}
