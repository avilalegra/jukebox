<?php

namespace App\Library\Application\AudioFileStorage;

use App\Shared\Application\AudioFile;

interface AudioFileStorageInterface
{

    /**
     * @param resource $fileContents
     * @throws AudioFileStorageException
     */
    public function writeFile(AudioFile $audioFile, $fileContents) : void;
}