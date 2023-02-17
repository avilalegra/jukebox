<?php

namespace App\Library\Application\Storage;

class AudioStorageException extends \Exception
{
    private function __construct(
        public readonly string $fileName,
        string                 $message,
        ?\Throwable            $previous = null
    )
    {
        parent::__construct($message, 0, $previous);
    }

    public static function importAudioFileException(string $fileName, ?\Throwable $previous = null): self
    {
        return new self("couldn't import file", $fileName, $previous);
    }

    public static function fileNotFoundException(string $fileName): self
    {
        return new self("couldn't find file", $fileName);
    }
}