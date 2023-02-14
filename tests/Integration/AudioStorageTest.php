<?php

use App\Library\Application\Storage\AudioStorageException;
use App\Library\Infrastructure\AudioStorage;
use App\Shared\Application\AudioFileName;
use App\Shared\Domain\AudioReadModel;
use App\Tests\IntegrationTestBase;

uses(IntegrationTestBase::class);

beforeEach(function () {
    $this->audiosFolder = $this->getParameter('audios_folder');
    $this->audioStorage = new AudioStorage($this->audiosFolder);
});


test('write audio file', function () {

    $this->audioStorage->writeAudioFile(
        sampleAudioFile(),
        resourceFromContents('some mp3 audio contents')
    );

    $expectedFilePath = "{$this->audiosFolder}/like-you-257s.mp3";

    expect(file_exists($expectedFilePath))->toBeTrue();
    expect(file_get_contents($expectedFilePath))->toEqual('some mp3 audio contents');

    unlink($expectedFilePath);
});



it('throws get audio file not found exception', function () {
    $this->audioStorage->getAudioFilePath(sampleAudioFile());
})->throws(AudioStorageException::class);


function sampleAudioFile(): AudioFileName
{
    return new AudioFileName(new AudioReadModel(
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
    ));
}
