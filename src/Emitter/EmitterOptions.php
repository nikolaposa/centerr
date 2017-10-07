<?php

declare(strict_types=1);

namespace CentErr\Emitter;

class EmitterOptions
{
    /**
     * @var bool
     */
    protected $includeTrace;

    /**
     * @var array
     */
    private static $defaults = [
        'includeTrace' => true,
    ];

    protected function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function create(array $options) : EmitterOptions
    {
        return new static(array_merge(self::$defaults, $options));
    }

    public static function createDefault() : EmitterOptions
    {
        return static::create([]);
    }

    public function includeTrace() : bool
    {
        return $this->includeTrace;
    }
}
