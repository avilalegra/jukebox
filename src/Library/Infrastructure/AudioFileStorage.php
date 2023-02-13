<?php

namespace App\Library\Infrastructure;

use App\Library\Application\AudioFileStorage\AudioFileStorageException;
use App\Library\Application\AudioFileStorage\AudioFileStorageInterface;
use App\Shared\Application\AudioFile;

class AudioFileStorage implements AudioFileStorageInterface
{

    public function __construct(
        private string $audiosFolder
    )
    {
    }


    /**
     * @inheritDoc
     */
    public function writeFile(AudioFile $audioFile, $fileContents): void
    {
        $outputFilePath = "{$this->audiosFolder}/{$audioFile->fileName()}";
        try {
            file_put_contents($outputFilePath, $fileContents);
        } catch (\Throwable $t) {
            throw AudioFileStorageException::writeException($t);
        }
    }
}