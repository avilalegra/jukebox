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


test('import audio file', function () {

    $this->audioStorage->importAudioFileAs(
        sampleAudioFile(),
        sampleAudioFilePath('english-course-intro.mp3')
    );

    $expectedFilePath = "{$this->audiosFolder}/like-you-257s.mp3";

    expect(file_exists($expectedFilePath))->toBeTrue();
    expect(md5(file_get_contents($expectedFilePath)))->toEqual('cd31a1b9bdc03753c8d0f25fe9909a64');

    unlink($expectedFilePath);
});



it('throws exception when recovering full path of not existing audio', function () {
    $this->audioStorage->getFullPath(sampleAudioFile());
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

function sampleAudioFilePath(string $fileName): string
{
    $projectDir = test()->getParameter('kernel.project_dir');
    return "{$projectDir}/tests/{$fileName}";
}