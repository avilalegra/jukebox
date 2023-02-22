<?php

namespace App\Audio\Application\Storage;

use App\Shared\Application\AudioFileName;

interface AudioStorageInterface
{
    /**
     * @throws AudioStorageException
     */
    public function importAudioFileAs(AudioFileName $fileName, string $sourceFilePath) : void;

    /**
     * @throws AudioStorageException
     */
    public function getFullPath(AudioFileName $fileName) : string;
}