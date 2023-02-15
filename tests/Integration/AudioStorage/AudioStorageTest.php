<?php

use App\Library\Application\Storage\AudioStorageException;
use App\Library\Infrastructure\AudioStorage;
use App\Shared\Application\AudioFileName;
use App\Tests\Integration\AudioStorage\AudioStorageTestCase;

uses(AudioStorageTestCase::class);

const IMPORTED_AUDIO_HASH = 'cd31a1b9bdc03753c8d0f25fe9909a64';

beforeEach(function () {
    $this->audiosFolder = $this->getParameter('audios_folder');
    $this->audioStorage = new AudioStorage($this->audiosFolder);
});


test('import audio file', function () {
    $expectedFilePath = "{$this->audiosFolder}/like-you-16s.mp3";

    $this->audioStorage->importAudioFileAs(
        new AudioFileName('like-you-16s.mp3'),
        getTestAudioPath('english-course-intro.mp3')
    );

    $this->expectAudioFileWritten($expectedFilePath, IMPORTED_AUDIO_HASH);

    unlink($expectedFilePath);
});

it('throws exception when recovering full path of not existing audio', function () {
    $this->audioStorage->getFullPath(new AudioFileName('whatever'));
})->throws(AudioStorageException::class);


