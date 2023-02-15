<?php

use App\Library\Application\AudioEntityRepositoryInterface;
use App\Library\Application\AudioImporter;
use App\Library\Application\GuidGeneratorInterface;
use App\Library\Application\Metadata\AudioMetadata;
use App\Library\Application\Metadata\AudioMetadataExtractorInterface;
use App\Library\Application\Storage\AudioStorageInterface;
use App\Library\Domain\AudioEntity;
use App\Shared\Application\AudioFileName;
use Hamcrest\Matchers;


const GUID = 'c1bc7bd8-be49-477e-9d72-38cc385c8bbf';


test('import audio', function () {
    $audioStorage = Mockery::spy(AudioStorageInterface::class);
    $audioRepository = Mockery::spy(AudioEntityRepositoryInterface::class);
    $metadataExtractor =
        mock(AudioMetadataExtractorInterface::class)
            ->expect(extractMetadata: fn($_) => new AudioMetadata(...audioData()));

    $importer = new AudioImporter(guidGenerator(GUID), $audioStorage, $metadataExtractor, $audioRepository);

    $audioFilePath = getTestAudioPath('english-course-intro.mp3');
    $importer->importAudio($audioFilePath);

    assertAudioEntityPersisted($audioRepository, audioData(['id' => GUID]));
    assertAudioFileImported($audioStorage, 'like-you-257s.mp3', $audioFilePath);
});


test('import audio without title metadata should default to audio file name', function () {
    $audioStorage = Mockery::spy(AudioStorageInterface::class);
    $audioRepository = Mockery::spy(AudioEntityRepositoryInterface::class);
    $metadataExtractor =
        mock(AudioMetadataExtractorInterface::class)
            ->expect(extractMetadata: fn($_) => new AudioMetadata(...audioData(['title' => null])));


    $importer = new AudioImporter(guidGenerator(GUID), $audioStorage, $metadataExtractor, $audioRepository);
    $audioFilePath = getTestAudioPath('english-course-intro.mp3');

    $importer->importAudio($audioFilePath);

    assertAudioEntityPersisted($audioRepository, audioData(['id' => GUID, 'title' => 'english-course-intro']));
    assertAudioFileImported($audioStorage, 'english-course-intro-257s.mp3', $audioFilePath);

});


function assertAudioEntityPersisted($audioRepository, array $expectedAudioData)
{
    $audioRepository
        ->shouldHaveReceived('add')
        ->with(Matchers::equalTo(new AudioEntity(...$expectedAudioData)));
}

function assertAudioFileImported($audioStorage, string $expectedFileName, string $sourceAudioFilePath)
{

    $audioStorage
        ->shouldHaveReceived('importAudioFileAs')
        ->with(Matchers::equalTo(new AudioFileName($expectedFileName)), $sourceAudioFilePath);
}

function audioData(array $overwrites = [])
{
    return dataPatcher([
        'title' => 'Like you',
        'artist' => 'Evanescence',
        'album' => 'The Open Door',
        'year' => 2009,
        'track' => 8,
        'genre' => 'Alternative Rock',
        'lyrics' => 'some lyrics',
        'duration' => '257',
        'extension' => 'mp3'
    ])($overwrites);
}

function guidGenerator(string $guid)
{
    return mock(GuidGeneratorInterface::class)
        ->expect(generateGuid: fn() => $guid);
}


