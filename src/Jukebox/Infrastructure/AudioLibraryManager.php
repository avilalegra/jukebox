<?php

namespace App\Jukebox\Infrastructure;

use App\Audio\Application\Import\AudiosImportResult;
use App\Audio\Application\Interactor\AudioLibraryManagerInterface;
use App\Audio\Domain\AudioReadModel;
use App\Audio\Infrastructure\AudioLibraryManager as ALManager;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;

readonly class AudioLibraryManager implements AudioLibraryManagerInterface
{

    public function __construct(
        private PlayerStatusInfoProviderInterface $playerStatusInfoProvider,
        private ALManager                         $decoratedManager
    )
    {
    }

    public function removeAudio(AudioReadModel $audio): void
    {
        $status = $this->playerStatusInfoProvider->playerStatus();
        if ($status->isPlaying($audio)) {
            throw new \Exception("can't remove an audio while it's being played");
        }

        $this->decoratedManager->removeAudio($audio);
    }

    public function importAudios(string $filePath): AudiosImportResult
    {
        return $this->decoratedManager->importAudios($filePath);
    }
}