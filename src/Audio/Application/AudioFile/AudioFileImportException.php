<?php

namespace App\Audio\Application\AudioFile;

use App\Audio\Application\AudioException;
use App\Audio\Domain\AudioReadModel;

class AudioFileImportException extends AudioException
{
    public function __construct(
        public AudioReadModel $audio,
        public string         $audioFilePath,
        ?\Throwable    $previous = null
    )
    {
        $message = sprintf("audio file import exception: file: %s, audio: %s", $this->audioFilePath, $this->audio->id);
        parent::__construct($message, $previous);
    }
}