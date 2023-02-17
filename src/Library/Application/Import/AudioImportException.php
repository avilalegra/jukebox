<?php

namespace App\Library\Application\Import;

class AudioImportException extends \Exception
{
    private function __construct(
        string                 $message,
        public readonly string $audioFilePath,
        ?\Throwable            $previous = null
    )
    {
        parent::__construct($message, 0, $previous);
    }

    public static function importException(string $audioFilePath, ?\Throwable $previous): self
    {
        return new self("couldn't import audio", $audioFilePath, $previous);
    }
}