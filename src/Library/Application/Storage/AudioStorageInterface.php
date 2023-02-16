<?php

namespace App\Library\Application\Storage;

use App\Shared\Application\AudioFileName;

interface AudioStorageInterface
{
    public function importAudioFileAs(AudioFileName $fileName, string $sourceFilePath) : void;

    /**
     * @throws AudioStorageException
     */
    public function getFullPath(AudioFileName $fileName) : string;
}