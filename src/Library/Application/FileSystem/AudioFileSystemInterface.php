<?php

namespace App\Library\Application\FileSystem;

use App\Shared\Application\AudioFile;

interface AudioFileSystemInterface
{

    /**
     * @param resource $fileContents
     * @throws LocalFileSystemException
     */
    public function writeFile(AudioFile $audioFile, $fileContents) : void;
}