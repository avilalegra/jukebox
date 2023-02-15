<?php

use App\Library\Application\Storage\AudioStorageInterface;
use App\Player\Application\Device\AudioDeviceException;
use App\Player\Infrastructure\OSProccess\OsProcessException;
use App\Player\Infrastructure\OSProccess\OSProcessRunner;
use App\Shared\Domain\AudioReadModel;
use App\Tests\Unit\AudioDevice\AudioDeviceTestCase;

uses(AudioDeviceTestCase::class);

const AUDIO_FILE_PATH = 'audio/file/path';


beforeEach(function () {
    $this->audioStorageMock = mock(AudioStorageInterface::class)->expect(getFullPath: fn() => AUDIO_FILE_PATH);
    $this->sampleAudioReadModel = new AudioReadModel(...array_merge(SAMPLE_AUDIO_METADATA, ['id' => SAMPLE_GUID]));
});

test('play audio', function () {
    $this->processRunner = Mockery::spy(OSProcessRunner::class);
    $audioDevice = $this->makeAudioDevice();

    $audioDevice->play($this->sampleAudioReadModel);

    $this->expectStartedPlaying(AUDIO_FILE_PATH);
});

it('throws exception', function () {
    $this->processRunner = mock(OSProcessRunner::class)->expect(run: fn() => throw new OsProcessException('command error output'));
    $audioDevice = $this->makeAudioDevice();

    $audioDevice->play($this->sampleAudioReadModel);
})->throws(AudioDeviceException::class);

