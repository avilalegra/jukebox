<?php

namespace App\Library\Application\Metadata;

class AudioMetadataExtractionException extends \Exception
{
    public function __construct(string $message = "", ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function forAudioFilePath(string $audioFilePath, ?\Throwable $previous): self
    {
        return new self(
            "couldn't extract audio metadata from file: " . $audioFilePath,
            $previous
        );
    }
}