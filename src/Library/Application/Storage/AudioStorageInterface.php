<?php

namespace App\Library\Application\Storage;

use App\Shared\Application\AudioFileName;

interface AudioStorageInterface
{

    /**
     * @param resource $fileContents
     * @throws AudioStorageException
     */
    public function writeAudioFile(AudioFileName $name,  $fileContents) : void;

    public function getAudioFilePath(AudioFileName $name) : string;
}