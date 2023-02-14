<?php

namespace App\Library\Infrastructure;

use App\Library\Application\Storage\AudioStorageInterface;
use App\Library\Application\Storage\AudioStorageException;
use App\Shared\Application\AudioFileName;

class AudioStorage implements AudioStorageInterface
{
    public function __construct(public string $storageFolder)
    {
    }

    /**
     * @inheritDoc
     */
    public function writeAudioFile(AudioFileName $name, $fileContents): void
    {
        $filePath = $this->filePath($name->fileName());
        try {
            file_put_contents($filePath, $fileContents);
        } catch (\Throwable $t) {
            throw AudioStorageException::writeException($filePath, $t);
        }
    }

    /**
     * @throws AudioStorageException
     */
    public function getAudioFilePath(AudioFileName $name): string
    {
        $filePath = $this->filePath($name->fileName());

        if (!file_exists($filePath)) {
            throw  AudioStorageException::fileNotFoundException($filePath);
        }

        return $name->fileName();
    }

    private function filePath(string $fileName): string
    {
        return $this->storageFolder . '/' . $fileName;
    }
}