<?php

namespace App\Library\Application\Storage;

use App\Shared\Application\AudioFile;

interface AudioStorageInterface
{

    /**
     * @param resource $fileContents
     * @throws AudioStorageException
     */
    public function writeAudioFile(AudioFile $audioFile, $fileContents) : void;

    public function getAudioFilePath(AudioFile $audioFile) : string;
}