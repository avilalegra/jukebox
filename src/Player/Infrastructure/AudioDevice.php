<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;


use App\Player\Application\AudioDeviceException;
use App\Player\Application\AudioDeviceInterface;
use App\Shared\Application\Audio;
use Symfony\Component\Process\Process;

class AudioDevice implements AudioDeviceInterface
{
    public function __construct(
        private string $audiosFolder,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function play(Audio $audio): void
    {
        $audioFilePath = "{$this->audiosFolder}/{$audio->album->name}/{$audio->name}.{$audio->ext}";

        $process = new Process(['mplayer', $audioFilePath]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);
        $process->run();

        if (!$process->isSuccessful()) {
            throw AudioDeviceException::playingException();
        }
    }
}
