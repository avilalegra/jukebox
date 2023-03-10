<?php

namespace App\Audio\Application;

use App\Audio\Application\AudioFile\AudioStorage;
use App\Audio\Application\Import\AudioImporter;
use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Interactor\AudioLibraryManagerInterface;
use App\Audio\Application\Interactor\AudioStorageInterface;
use App\Audio\Domain\AudioReadModel;

readonly class AudioLibraryManager implements AudioLibraryManagerInterface
{

    public function __construct(
        private AudioEntityRepositoryInterface $audioRepository,
        private AudioStorage                   $audioStorage,
        private AudioImporter                  $audioImporter
    )
    {
    }

    public function removeAudio(AudioReadModel $audio): void
    {
        $audioEntity = $this->audioRepository->find($audio->id);
        $this->audioRepository->remove($audioEntity);
        $this->audioStorage->removeAudioFile($audio);
    }

    public function importAudios(string $filePath): AudiosImportResult
    {
        return $this->audioImporter->import($filePath);
    }
}