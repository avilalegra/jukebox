<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Import\AudiosSourceInterface;
use App\Audio\Domain\AudioReadModel;

interface AudioLibraryManagerInterface
{
    public function importAudios(AudiosSourceInterface $audiosSource) : AudiosImportResult;

    public function removeAudio(AudioReadModel $audio): void;
}