<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioFile\AudioFileNotFoundException;
use App\Audio\Application\AudioFile\AudioStorageInterface;
use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;
use App\Shared\Application\File\LocalFileSystemInterface;

readonly class AudioStorage implements AudioStorageInterface
{
    public function __construct(
        private string                   $audiosFolder,
        private LocalFileSystemInterface $localFileSystem
    )
    {
    }


    public function importAudioFile(AudioReadModel $audio, string $audioFilePath): void
    {
        $targetPath = $this->targetPath($audio);
        $this->localFileSystem->moveFile($audioFilePath, $targetPath);
    }

    public function findAudioFile(AudioReadModel $audio): AudioFile
    {
        $targetPath = $this->targetPath($audio);

        if (!$this->localFileSystem->exists($targetPath)) {
            throw  new AudioFileNotFoundException($audio);
        }

        return new AudioFile($targetPath);
    }

    private function targetPath(AudioReadModel $audio): string
    {
        return $this->audiosFolder . '/' . $audio->id;
    }

    public function removeAudioFile(AudioReadModel $audio): void
    {
        $this->localFileSystem->remove($this->targetPath($audio));
    }
}