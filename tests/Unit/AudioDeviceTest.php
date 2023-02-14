<?php

use App\Library\Application\FileSystem\AudioFileSystemInterface;
use App\Player\Application\Device\AudioDeviceException;
use App\Player\Infrastructure\AudioDevice;
use App\Player\Infrastructure\OSProccess\OsProcessException;
use App\Player\Infrastructure\OSProccess\OSProcessRunner;
use App\Shared\Domain\AudioReadModel;


test('play audio', function () {

    $processRunner = Mockery::spy(OSProcessRunner::class);
    $audioDevice = new AudioDevice(audioFileSystemMock(), $processRunner);

    $audioDevice->play(sampleAudio());

    $processRunner
        ->shouldHaveReceived('run')
        ->with(['mplayer', 'audio/file/path']);
});

it('throws exception', function () {

    $processRunner = mock(OSProcessRunner::class)
        ->expect(run: fn() => throw new OsProcessException('command error output'));

    $audioDevice = new AudioDevice(audioFileSystemMock(), $processRunner);

    $audioDevice->play(sampleAudio());

})->throws(AudioDeviceException::class);


function sampleAudio(): AudioReadModel
{
    return new AudioReadModel(
        '3b798c60-6703-44e4-a617-d8c97fde5043',
        'Like you',
        'Evanescence',
        'The Open Door',
        2009,
        8,
        'Alternative Rock',
        'some lyrics',
        '257',
        'mp3'
    );
}

function audioFileSystemMock(): AudioFileSystemInterface
{
    return mock(AudioFileSystemInterface::class)
        ->expect(getAudioFilePath: fn() => 'audio/file/path');
}