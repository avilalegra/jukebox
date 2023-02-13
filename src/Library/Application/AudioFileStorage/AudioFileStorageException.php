<?php

namespace App\Library\Application\AudioFileStorage;

class AudioFileStorageException extends \Exception
{
    public function __construct(string $message = "", ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public static function writeException(?\Throwable $previous): self
    {
        return new self("couldn't write audio file", $previous);
    }
}