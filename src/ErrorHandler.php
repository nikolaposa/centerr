<?php

declare(strict_types=1);

namespace CentErr;

use CentErr\Emitter\EmitterInterface;
use ErrorException;
use Throwable;

class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @var EmitterInterface
     */
    protected $emitter;

    /**
     * @var callable[]
     */
    protected $processors;

    /**
     * @var array
     */
    protected $options = [
        'blockingErrors' => true,
    ];

    /**
     * @var bool
     */
    protected $treatErrorsAsExceptions = false;

    /**
     * @var bool
     */
    private $registered = false;

    public function __construct(EmitterInterface $emitter, array $processors = [], array $options = [])
    {
        $this->emitter = $emitter;
        $this->processors = $processors;
        $this->options = array_merge($this->options, $options);

        $this->treatErrorsAsExceptions = $this->options['blockingErrors'];
    }

    final public function register() : void
    {
        if ($this->registered) {
            return;
        }

        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'onShutdown']);

        $this->registered = true;
    }

    final public function unregister() : void
    {
        if (!$this->registered) {
            return;
        }

        restore_error_handler();
        restore_exception_handler();

        $this->registered = false;
    }

    final public function isRegistered() : bool
    {
        return $this->registered;
    }

    public function handleError(int $level, string $message, string  $file = null, int $line = null) : bool
    {
        if (! ($level & error_reporting())) {
            return false;
        }

        $exception = new ErrorException($message, 0, $level, $file, $line);

        if ($this->treatErrorsAsExceptions) {
            throw $exception;
        }

        $this->handleException($exception);

        if ($this->isFatalError($level)) {
            $this->terminate();
        }

        return true;
    }

    public function handleException(Throwable $exception) : void
    {
        $exception = $this->process($exception);

        $this->emit($exception);
    }

    public function onShutdown() : void
    {
        $this->treatErrorsAsExceptions = false;

        $error = error_get_last();

        if ($error && $this->isFatalError($error['type'])) {
            $this->handleError(
                $error['type'],
                $error['message'],
                $error['file'],
                $error['line']
            );
        }
    }

    protected function process(Throwable $exception) : Throwable
    {
        foreach ($this->processors as $processor) {
            $exception = $processor($exception);
        }

        return $exception;
    }

    protected function emit(Throwable $exception) : void
    {
        $this->emitter->emit($exception);
    }

    final protected function isFatalError(int $errorLevel) : bool
    {
        $fatalErrorLevels = E_ERROR | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR;

        return ($errorLevel & $fatalErrorLevels) > 0;
    }

    final protected function terminate() : void
    {
        exit(1);
    }
}
