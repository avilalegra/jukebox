<?php

namespace App\Audio\Application\AudioFile;

use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;

interface AudioStorageInterface
{
    /**
     * @throws AudioFileImportException
     */
    public function importAudioFile(AudioReadModel $audio, string $audioFilePath): void;

    /**
     * @throws AudioFileNotFoundException
     */
    public function findAudioFile(AudioReadModel $audio): AudioFile;

}