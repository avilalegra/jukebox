<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;

interface AudioStorageInterface
{
    public function findAudioFile(AudioReadModel $audio): AudioFile;
}