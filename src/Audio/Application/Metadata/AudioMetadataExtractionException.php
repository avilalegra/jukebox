<?php

namespace App\Audio\Application\Metadata;

use App\Player\PlayerException;

class AudioMetadataExtractionException extends PlayerException
{
    public function __construct(
        public readonly string $audioFilePath,
        ?\Throwable            $previous = null
    )
    {
        $message = sprintf("audio metadata extraction exception: file: %s", $this->audioFilePath);
        parent::__construct($message, $previous);
    }
}