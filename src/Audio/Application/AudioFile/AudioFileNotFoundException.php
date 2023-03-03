<?php

namespace App\Audio\Application\AudioFile;

use App\Audio\Application\AudioException;
use App\Audio\Domain\AudioReadModel;

class AudioFileNotFoundException extends AudioException
{
    public function __construct(
        public readonly AudioReadModel $audioReadModel
    )
    {
        $message = sprintf('audio file not found exception: audio: %s', $this->audioReadModel->id);
        parent::__construct($message);
    }
}