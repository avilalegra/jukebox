<?php

use App\Library\Application\Storage\AudioStorageException;
use App\Library\Infrastructure\AudioStorage;
use App\Shared\Application\AudioFileName;
use App\Tests\IntegrationTestBase;

uses(IntegrationTestBase::class);

beforeEach(function () {
    $this->audiosFolder = $this->getParameter('audios_folder');
    $this->audioStorage = new AudioStorage($this->audiosFolder);
});


test('import audio file', function () {

    $this->audioStorage->importAudioFileAs(
        new AudioFileName('like-you-16s.mp3'),
        testAudioPath('english-course-intro.mp3')
    );

    $expectedFilePath = "{$this->audiosFolder}/like-you-16s.mp3";

    expect(file_exists($expectedFilePath))->toBeTrue();
    expect(md5(file_get_contents($expectedFilePath)))->toEqual('cd31a1b9bdc03753c8d0f25fe9909a64');

    unlink($expectedFilePath);
});



it('throws exception when recovering full path of not existing audio', function () {
    $this->audioStorage->getFullPath(new AudioFileName('whatever'));
})->throws(AudioStorageException::class);


