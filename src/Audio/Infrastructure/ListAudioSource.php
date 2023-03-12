<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Import\AudiosSourceInterface;

readonly class ListAudioSource implements AudiosSourceInterface
{
    public function __construct(
        private array $audioFilePaths
    )
    {
    }

    public function audioFilePaths(): \Generator
    {
        foreach ($this->audioFilePaths as $audioFilePath) {
            yield $audioFilePath;
        }
    }
}