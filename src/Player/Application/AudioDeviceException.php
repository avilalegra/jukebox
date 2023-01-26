<?php

declare(strict_types=1);

namespace App\Player\Application;

use Exception;
use Throwable;

class AudioDeviceException extends Exception
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0,  $previous);
    }

    public static function playingException(): self
    {
        return new self('audio device playing exception');
    }

    public static function stopDeviceException(): self
    {
        return new self('audio device stopping exception');
    }

    public static function statusRecoveringException(): self
    {
        return new self('audio device status recovering exception');
    }
}