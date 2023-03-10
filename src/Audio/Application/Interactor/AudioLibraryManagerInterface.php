<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Domain\AudioReadModel;

interface AudioLibraryManagerInterface
{
    public function importAudios(string $filePath) : AudiosImportResult;

    public function removeAudio(AudioReadModel $audio): void;
}