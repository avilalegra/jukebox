<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Domain\AudioReadModel;

interface AudioLibraryManagerInterface
{
    public function removeAudio(AudioReadModel $audio): void;
}