<?php

namespace App\Library\Application\FileSystem;

use App\Shared\Application\AudioFile;

interface AudioFileSystemInterface
{

    /**
     * @param resource $fileContents
     * @throws LocalFileSystemException
     */
    public function writeAudioFile(AudioFile $audioFile, $fileContents) : void;

    public function getAudioFilePath(AudioFile $audioFile) : string;
}