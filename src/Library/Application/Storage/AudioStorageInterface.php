<?php

namespace App\Library\Application\Storage;

use App\Shared\Application\AudioFileName;

interface AudioStorageInterface
{
    public function importAudioFileAs(AudioFileName $name, string $sourceFilePath) : void;

    /**
     * @throws AudioStorageException
     */
    public function getFullPath(AudioFileName $name) : string;
}