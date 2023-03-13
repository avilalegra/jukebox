<?php

namespace App\Audio\Application;

use App\Audio\Application\AudioFile\AudioStorage;
use App\Audio\Application\Import\AudioImporter;
use App\Audio\Application\Import\AudioImportError;
use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Import\AudiosSourceInterface;
use App\Audio\Application\Interactor\AudioLibraryManagerInterface;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;

readonly class AudioLibraryManager implements AudioLibraryManagerInterface
{

    public function __construct(
        private AudioEntityRepositoryInterface    $audioRepository,
        private AudioStorage                      $audioStorage,
        private AudioImporter                     $audioImporter,
        private PlayerStatusInfoProviderInterface $playerStatusInfoProvider,
    )
    {
    }

    public function removeAudio(AudioReadModel $audio): void
    {
        $status = $this->playerStatusInfoProvider->playerStatus();

        if ($status->isPlaying($audio)) {
            throw new \Exception("can't remove an audio while it's being played");
        }

        $audioEntity = $this->audioRepository->find($audio->id);
        $this->audioRepository->remove($audioEntity);
        $this->audioStorage->removeAudioFile($audio);
    }

    public function importAudios(AudiosSourceInterface $audiosSource): AudiosImportResult
    {
        $errors = [];
        foreach ($audiosSource->audioFilePaths() as $audioFilePath) {
            try {
                $this->audioImporter->importAudio($audioFilePath);
            } catch (\Throwable $e) {
                $errors[] = new AudioImportError($audioFilePath, $e->getTraceAsString());
            }
        }

        return AudiosImportResult::withErrors(...$errors);
    }
}