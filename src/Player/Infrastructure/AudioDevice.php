<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Audio\Application\AudioFile\AudioStorageInterface;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Player\AudioDeviceInterface;
use App\Player\Infrastructure\OSProcess\OSProcessManagerInterface;


readonly class AudioDevice implements AudioDeviceInterface
{
    public function __construct(
        private AudioStorageInterface     $audioStorage,
        private OSProcessManagerInterface $processManager
    )
    {
    }


    public function play(AudioReadModel $audio): void
    {
        $audioFile = $this->audioStorage->findAudioFile($audio);
        $this->processManager->run(['mplayer', $audioFile->fullPath]);
    }
}
