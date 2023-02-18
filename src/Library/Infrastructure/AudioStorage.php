<?php

namespace App\Library\Infrastructure;

use App\Library\Application\Storage\AudioStorageInterface;
use App\Library\Application\Storage\AudioStorageException;
use App\Shared\Application\AudioFileName;

class AudioStorage implements AudioStorageInterface
{
    public function __construct(
        private string                   $storageFolder,
        private LocalFileSystemInterface $localFileSystem
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function importAudioFileAs(AudioFileName $fileName, string $sourceFilePath): void
    {
        $targetPath = $this->targetPath($fileName);

        try {
            $this->localFileSystem->moveFile($sourceFilePath, $targetPath);
        } catch (\Throwable $t) {
            throw AudioStorageException::importAudioFileException($targetPath, $t);
        }
    }

    /**
     * @inheritDoc
     */
    public function getFullPath(AudioFileName $fileName): string
    {
        $targetPath = $this->targetPath($fileName);

        if (!$this->localFileSystem->exists($targetPath)) {
            throw  AudioStorageException::fileNotFoundException($targetPath);
        }

        return $targetPath;
    }

    private function targetPath(AudioFileName $fileName): string
    {
        return $this->storageFolder . '/' . $fileName->fileName;
    }
}