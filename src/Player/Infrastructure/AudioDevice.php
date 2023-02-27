<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Audio\Application\AudioFileName;
use App\Audio\Application\Storage\AudioStorageInterface;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Device\AudioDeviceException;
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
            $audioFile = AudioFileName::fromAudio($audio);
            $audioFilePath = $this->audioStorage->getFullPath($audioFile);
            $this->processRunner->run(['mplayer', $audioFilePath]);

        } catch (OsProcessException $e) {
            throw AudioDeviceException::playAudioException($audio, $e);
        }
    }
}
