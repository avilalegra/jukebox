<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Audio\Application\Interactor\AudioStorageInterface;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Player\AudioDeviceInterface;
use App\Player\Infrastructure\OSProcess\OSProcessManager;


readonly class AudioDevice implements AudioDeviceInterface
{
    public function __construct(
        private AudioStorageInterface     $audioStorage,
        private OSProcessManager $processManager
    )
    {
    }


    public function play(AudioReadModel $audio): void
    {
        $audioFile = $this->audioStorage->findAudioFile($audio);
        $this->processManager->run(['mplayer', $audioFile->fullPath]);
    }
}
