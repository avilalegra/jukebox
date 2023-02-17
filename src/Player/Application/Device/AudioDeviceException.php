<?php

declare(strict_types=1);

namespace App\Player\Application\Device;

use App\Shared\Domain\AudioReadModel;

class AudioDeviceException extends \Exception
{
    private function __construct(
        public AudioReadModel $audio,
        \Throwable            $previous = null
    )
    {
        parent::__construct("couldn't play audio", 0, $previous);
    }

    public static function playAudioException(AudioReadModel $audio, ?\Throwable $previous = null): self
    {
        return new self($audio, $previous);
    }
}
