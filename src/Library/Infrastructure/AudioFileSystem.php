<?php

namespace App\Library\Infrastructure;

use App\Library\Application\FileSystem\AudioFileSystemInterface;
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
    public function writeFile(AudioFile $audioFile, $fileContents): void
    {
        $this->localFileSystem->writeFile($audioFile->fileName(), $fileContents); 
    }
}