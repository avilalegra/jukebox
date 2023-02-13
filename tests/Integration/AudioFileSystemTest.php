<?php

use App\Library\Application\FileSystem\LocalFileSystemException;
use App\Library\Infrastructure\AudioFileSystem;
use App\Library\Infrastructure\LocalFileSystem;
use App\Shared\Application\AudioFile;
use App\Shared\Domain\AudioReadModel;
use App\Tests\IntegrationTestBase;

uses(IntegrationTestBase::class);

beforeEach(function () {
    $this->audiosFolder = $this->getParameter('audios_folder');
    $this->audioFileSystem = new AudioFileSystem(new LocalFileSystem($this->audiosFolder));
});



test('write audio file', function () {
    $audioFile = new AudioFile(new AudioReadModel(
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

    $this->audioFileSystem->writeFile($audioFile, sampleAudioFile('some mp3 audio contents'));

    $expectedFilePath = "{$this->audiosFolder}/like-you-257s.mp3";

    expect(file_exists($expectedFilePath))->toBeTrue();
    expect(file_get_contents($expectedFilePath))->toEqual('some mp3 audio contents');

    unlink($expectedFilePath);
});

it('throws get audio file not found exception', function() {
    $audioFile = new AudioFile(new AudioReadModel(
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

    $this->audioFileSystem->getAudioFilePath($audioFile);

})->throws(LocalFileSystemException::class);


/**
 * @return false|resource
 */
function sampleAudioFile(string $contents)
{
    $audioStream = fopen('php://memory', 'r+');
    fwrite($audioStream, $contents);
    rewind($audioStream);
    return $audioStream;
}
