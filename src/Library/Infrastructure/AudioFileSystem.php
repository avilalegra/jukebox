<?php

namespace App\Library\Infrastructure;

use App\Library\Application\FileSystem\AudioFileSystemInterface;
use App\Library\Application\FileSystem\LocalFileSystemException;
use App\Library\Application\FileSystem\LocalFileSystemInterface;
use App\Shared\Application\AudioFile;

class AudioFileSystem implements AudioFileSystemInterface
{

    public function __construct(
        private LocalFileSystemInterface $localFileSystem
    )
    {
    }


    /**
     * @inheritDoc
     */
    public function writeAudioFile(AudioFile $audioFile, $fileContents): void
    {
        $this->localFileSystem->writeFile($audioFile->fileName(), $fileContents);
    }

    /**
     * @throws LocalFileSystemException
     */
    public function getAudioFilePath(AudioFile $audioFile): string
    {
        return $this->localFileSystem->getExistingFilePath($audioFile->fileName());
    }
}