<?php

declare(strict_types=1);

namespace CentErr\Processor;

use Psr\Log\LoggerInterface;
use Throwable;

final class LogProcessor implements ProcessorInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $dontLog;

    public function __construct(LoggerInterface $logger, array $dontLog = [])
    {
        $this->logger = $logger;
        $this->dontLog = $dontLog;
    }

    public function __invoke(Throwable $exception) : Throwable
    {
        if ($this->shouldLog($exception)) {
            $this->logger->error($exception->getMessage());
        }

        return $exception;
    }

    private function shouldLog(Throwable $error) : bool
    {
        foreach ($this->dontLog as $type) {
            if ($error instanceof $type) {
                return false;
            }
        }

        return true;
    }
}
