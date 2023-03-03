<?php

namespace App\Audio\Application\Import;

use App\Audio\Application\AudioException;

class AudioImportException extends AudioException
{
    public function __construct(
        public readonly string $filePath,
        ?\Throwable            $previous = null
    )
    {
        $message = sprintf("audio importation exception: file: %s", $this->filePath);
        parent::__construct($message, $previous);
    }
}