<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Audio\Application\AudioFile\AudioStorageInterface;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Device\AudioDevicePlayingException;
use App\Player\Application\Device\AudioDeviceInterface;
use App\Player\Infrastructure\OSProccess\OsProcessException;
use App\Player\Infrastructure\OSProccess\OSProcessRunnerInterface;


class AudioDevice implements AudioDeviceInterface
{
    public function __construct(
        private AudioStorageInterface    $audioStorage,
        private OSProcessRunnerInterface $processRunner
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function play(AudioReadModel $audio): void
    {
        try {
            $audioFile = $this->audioStorage->findAudioFile($audio);
            $this->processRunner->run(['mplayer', $audioFile->fullPath]);
        } catch (OsProcessException $e) {
            throw new AudioDevicePlayingException($audio, $e);
        }
    }
}
