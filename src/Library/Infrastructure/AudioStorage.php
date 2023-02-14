<?php

namespace App\Library\Infrastructure;

use App\Library\Application\Storage\AudioStorageInterface;
use App\Library\Application\Storage\AudioStorageException;
use App\Shared\Application\AudioFile;

class AudioStorage implements AudioStorageInterface
{
    public function __construct(public string $storageFolder)
    {
    }

    /**
     * @inheritDoc
     */
    public function writeAudioFile(AudioFile $audioFile, $fileContents): void
    {
        $filePath = $this->filePath($audioFile->fileName());
        try {
            file_put_contents($filePath, $fileContents);
        } catch (\Throwable $t) {
            throw AudioStorageException::writeException($filePath, $t);
        }
    }

    /**
     * @throws AudioStorageException
     */
    public function getAudioFilePath(AudioFile $audioFile): string
    {
        $filePath = $this->filePath($audioFile->fileName());

        if (!file_exists($filePath)) {
            throw  AudioStorageException::fileNotFoundException($filePath);
        }

        return $audioFile->fileName();
    }

    private function filePath(string $fileName): string
    {
        return $this->storageFolder . '/' . $fileName;
    }
}