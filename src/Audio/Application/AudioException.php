<?php

namespace App\Audio\Application;

class AudioException extends \Exception
{
    const CODE = 1;

    public function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, self::CODE, $previous);
    }
}