<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Player\Application\Device\AudioDeviceException;
use App\Player\Application\Device\AudioDeviceInterface;
use App\Player\Infrastructure\OSProccess\OsProcessException;
use App\Player\Infrastructure\OSProccess\OSProcessRunner;
use App\Shared\Application\AudioFile;
use App\Shared\Domain\AudioReadModel;


class AudioDevice implements AudioDeviceInterface
{
    public function __construct(
        private string          $audiosFolder,
        private OSProcessRunner $processRunner
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function play(AudioReadModel $audio): void
    {
        $audioFile = new AudioFile($audio);
        $audioFilePath = "{$this->audiosFolder}/{$audioFile->fileName()}";

        try {
            $this->processRunner->run(['mplayer', $audioFilePath]);
        } catch (OsProcessException $e) {
            throw AudioDeviceException::playAudioException($e);
        }
    }
}
