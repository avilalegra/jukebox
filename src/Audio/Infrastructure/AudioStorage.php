<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioFile\AudioFileImportException;
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

    /**
     * @inheritDoc
     */
    public function importAudioFile(AudioReadModel $audio, string $audioFilePath): void
    {
        $targetPath = $this->targetPath($audio);

        try {
            $this->localFileSystem->moveFile($audioFilePath, $targetPath);
        } catch (\Throwable $t) {
            throw new AudioFileImportException($audio, $audioFilePath, $t);
        }
    }


    /**
     * @inheritDoc
     */
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
        return $this->storageFolder . '/' . $audio->id;
    }
}