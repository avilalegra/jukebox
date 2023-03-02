<?php

namespace App\Audio\Application\Import;

readonly class AudioImportError
{
    public function __construct(
        public string $audioFilePath,
        public string $trace
    )
    {
    }
}