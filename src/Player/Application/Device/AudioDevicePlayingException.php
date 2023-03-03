<?php

declare(strict_types=1);

namespace App\Player\Application\Device;

use App\Audio\Domain\AudioReadModel;
use App\Player\PlayerException;

class AudioDevicePlayingException extends PlayerException
{
    public function __construct(
        public readonly AudioReadModel $audio,
        \Throwable                     $previous = null
    )
    {
        $message = sprintf('audio device playing exception: audio: %s', $this->audio->id);
        parent::__construct($message, $previous);
    }
}
