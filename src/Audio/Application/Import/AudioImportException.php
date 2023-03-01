<?php

namespace App\Audio\Application\Import;

class AudioImportException extends \Exception
{
    public function __construct(
        public readonly string $filePath,
        ?\Throwable            $previous = null
    )
    {
        parent::__construct("audio importation failed", 0, $previous);
    }
}