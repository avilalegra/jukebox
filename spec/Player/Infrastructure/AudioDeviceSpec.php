<?php

namespace spec\App\Player\Infrastructure;

use App\Audio\Application\AudioFileName;
use App\Audio\Application\AudioFile\AudioStorageInterface;
use App\Player\Application\Device\AudioDeviceException;
use App\Player\Infrastructure\OSProccess\OsProcessException;
use App\Player\Infrastructure\OSProccess\OSProcessRunnerInterface;
use PhpSpec\ObjectBehavior;

class AudioDeviceSpec extends ObjectBehavior
{
    const AUDIO_FILE_PATH = 'audio/path/like-you-257.mp3';

    function let(AudioStorageInterface $audioStorage, OSProcessRunnerInterface $osProcessRunner)
    {
        $audioStorage
            ->getFullPath(new AudioFileName('like-you-257s.mp3'))
            ->willReturn(self::AUDIO_FILE_PATH);

        $this->beConstructedWith($audioStorage, $osProcessRunner);
    }

    function it_should_play_an_audio(OSProcessRunnerInterface $osProcessRunner)
    {
        $this->play(sampleAudioReadModel());

        $osProcessRunner
            ->run(['mplayer', self::AUDIO_FILE_PATH])
            ->shouldHaveBeenCalled();
    }

    function it_should_throw_exception(AudioStorageInterface $audioStorage, OSProcessRunnerInterface $osProcessRunner)
    {
        $osProcessRunner
            ->run(['mplayer', self::AUDIO_FILE_PATH])
            ->willThrow(OsProcessException::runException(['mplayer', self::AUDIO_FILE_PATH], 'command error output'));

        $this->beConstructedWith($audioStorage, $osProcessRunner);

        $this->shouldThrow(AudioDeviceException::class)
            ->duringPlay(sampleAudioReadModel());
    }
}
