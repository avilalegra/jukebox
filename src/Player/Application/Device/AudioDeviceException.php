<?php

declare(strict_types=1);

namespace App\Player\Application\Device;

class AudioDeviceException extends \Exception
{
    private function __construct($message = '', \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function playAudioException(?\Throwable $previous): self
    {
        return new self("couldn't play audio", $previous);
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