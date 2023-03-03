<?php

namespace App\Audio\Domain;

readonly class AudioFile
{
    public function __construct(
        public string $fullPath,
    )
    {
    }
}