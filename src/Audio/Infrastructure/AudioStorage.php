<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioFile\AudioStorageException;
use App\Audio\Application\AudioFile\AudioStorageInterface;
use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;
use App\Shared\Application\File\LocalFileSystemInterface;

class AudioStorage implements AudioStorageInterface
{
    public function __construct(
        private string                   $storageFolder,
        private LocalFileSystemInterface $localFileSystem
    )
    {
    }

    public function importAudioFile(AudioReadModel $audio, string $audioFilePath): void
    {
        $targetPath = $this->targetPath($audio);

        try {
            $this->localFileSystem->moveFile($audioFilePath, $targetPath);
        } catch (\Throwable $t) {
            throw AudioStorageException::importAudioFileException($targetPath, $t);
        }
    }

    public function findAudioFile(AudioReadModel $audio): AudioFile
    {
        $targetPath = $this->targetPath($audio);

        if (!$this->localFileSystem->exists($targetPath)) {
            throw  AudioStorageException::fileNotFoundException($targetPath);
        }

        return new AudioFile($targetPath);
    }

    private function targetPath(AudioReadModel $audio): string
    {
        return $this->storageFolder . '/' . $audio->id;
    }
}