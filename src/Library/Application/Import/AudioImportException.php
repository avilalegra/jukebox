<?php

namespace App\Library\Application\Import;

class AudioImportException extends \Exception
{
    private function __construct(
        public readonly string $audioFilePath,
        ?\Throwable            $previous = null
    )
    {
        parent::__construct("couldn't import audio", 0, $previous);
    }

    public static function importException(string $audioFilePath, ?\Throwable $previous = null): self
    {
        return new self($audioFilePath, $previous);
    }
}