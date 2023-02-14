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
    public function importAudioFileAs(AudioFileName $name, string $sourceFilePath): void
    {
        $filePath = $this->filePath($name->fileName);
        try {
            $h = fopen($sourceFilePath, 'r');
            file_put_contents($filePath, $h);
        } catch (\Throwable $t) {
            throw AudioStorageException::writeException($filePath, $t);
        }
    }

    /**
     * @inheritDoc
     */
    public function getFullPath(AudioFileName $name): string
    {
        $filePath = $this->filePath($name->fileName);

        if (!file_exists($filePath)) {
            throw  AudioStorageException::fileNotFoundException($filePath);
        }

        return $name->fileName;
    }

    private function filePath(string $fileName): string
    {
        return $this->storageFolder . '/' . $fileName;
    }
}