<?php

namespace App\Audio\Application\AudioFile;

use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;

interface AudioStorageInterface
{
    public function importAudioFile(AudioReadModel $audio, string $audioFilePath): void;

    public function findAudioFile(AudioReadModel $audio): AudioFile;

    public function removeAudioFile(AudioReadModel $audio) : void;
}