<?php

declare(strict_types=1);

namespace CentErr\Tests\Processor;

use CentErr\Processor\LogProcessor;
use DomainException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use RuntimeException;

class LogProcessorTest extends TestCase
{
    /**
     * @test
     */
    public function it_logs_any_exception_by_default()
    {
        $loggerSpy = $this->prophesize(LoggerInterface::class);
        $processor = new LogProcessor($loggerSpy->reveal());

        $processor(new RuntimeException('Cannot connect to the database'));

        $loggerSpy->error('Cannot connect to the database')->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function it_doesnt_log_exception_of_type_that_shouldnt_be_logged()
    {
        $loggerSpy = $this->prophesize(LoggerInterface::class);
        $processor = new LogProcessor($loggerSpy->reveal(), [
            DomainException::class,
        ]);

        $processor(new DomainException('Invalid input'));

        $loggerSpy->error('Invalid input')->shouldNotHaveBeenCalled();
    }
}
