<?php

namespace App\Audio\Application\Metadata;

class AudioMetadataExtractionException extends \Exception
{
    private function __construct(
        public readonly string $audioFilePath,
        ?\Throwable $previous = null
    )
    {
        parent::__construct("couldn't extract audio metadata from file", 0, $previous);
    }

    public static function forAudioFilePath(string $audioFilePath, ?\Throwable $previous = null): self
    {
        return new self(
            $audioFilePath,
            $previous
        );
    }
}