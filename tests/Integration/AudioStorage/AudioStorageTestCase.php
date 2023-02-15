<?php

namespace App\Tests\Integration\AudioStorage;

use App\Library\Infrastructure\AudioStorage;
use App\Tests\Integration\IntegrationTestCase;

class AudioStorageTestCase extends IntegrationTestCase
{
    protected string $audiosFolder;
    protected AudioStorage $audioStorage;

    protected function expectAudioFileWritten(string $expectedFilePath, string $audioFileHash): void
    {
        expect(file_exists($expectedFilePath))
            ->toBeTrue()
            ->and(md5(file_get_contents($expectedFilePath)))
            ->toEqual($audioFileHash);
    }
}