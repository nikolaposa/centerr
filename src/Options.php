<?php

declare(strict_types=1);

namespace CentErr;

class Options
{
    /**
     * @var bool
     */
    protected $blockingErrors;

    /**
     * @var array
     */
    private static $defaults = [
        'blockingErrors' => true,
    ];

    protected function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function create(array $options) : Options
    {
        return new static(array_merge(self::$defaults, $options));
    }

    public static function createDefault() : Options
    {
        return static::create([]);
    }

    public function blockingErrors() : bool
    {
        return $this->blockingErrors;
    }
}
