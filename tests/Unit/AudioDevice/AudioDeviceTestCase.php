<?php

namespace App\Tests\Unit\AudioDevice;

use App\Player\Infrastructure\AudioDevice;
use PHPUnit\Framework\TestCase;

class AudioDeviceTestCase extends TestCase
{
    public $processRunner;
    protected $audioStorageMock;

    protected $sampleAudioReadModel;

    protected function makeAudioDevice(): AudioDevice
    {
        return new AudioDevice($this->audioStorageMock, $this->processRunner);
    }

    protected function expectStartedPlaying(string $audioFilePath): void
    {
        $this->processRunner
            ->shouldHaveReceived('run')
            ->with(['mplayer', $audioFilePath]);
    }
}