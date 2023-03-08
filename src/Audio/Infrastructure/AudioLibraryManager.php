<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Application\AudioFile\AudioStorageInterface;
use App\Audio\Application\Interactor\AudioLibraryManagerInterface;
use App\Audio\Domain\AudioReadModel;

readonly class AudioLibraryManager implements AudioLibraryManagerInterface
{

    public function __construct(
        private AudioEntityRepositoryInterface $audioRepository,
        private AudioStorageInterface          $audioStorage
    )
    {
    }

    public function removeAudio(AudioReadModel $audio): void
    {
        $audioEntity = $this->audioRepository->find($audio->id);
        $this->audioRepository->remove($audioEntity);
        $this->audioStorage->removeAudioFile($audio);
    }
}