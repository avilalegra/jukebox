<?php

use App\Library\Application\AudioEntityRepositoryInterface;
use App\Library\Application\AudioImporter;
use App\Library\Application\GuidGeneratorInterface;
use App\Library\Application\Metadata\AudioMetadata;
use App\Library\Application\Metadata\AudioMetadataExtractorInterface;
use App\Library\Application\Storage\AudioStorageInterface;
use App\Shared\Application\AudioFileName;


test('import audio', function () {
    $guidGenerator = mock(GuidGeneratorInterface::class)
        ->expect(generateGuid: fn() => 'c1bc7bd8-be49-477e-9d72-38cc385c8bbf');

    $audioStorage = Mockery::spy(AudioStorageInterface::class);
    $audioRepository = Mockery::spy(AudioEntityRepositoryInterface::class);
    $metadataExtractor = mock(AudioMetadataExtractorInterface::class)
        ->expect(extractMetadata: fn($_) => new AudioMetadata(
            'Like you',
            'Evanescence',
            'The Open Door',
            2009,
            8,
            'Alternative Rock',
            'some lyrics',
            '257',
        ));

    $importer = new AudioImporter($guidGenerator, $audioStorage, $metadataExtractor, $audioRepository);

    $audioFilePath = testAudioPath('english-course-intro.mp3');

    $importer->importAudio($audioFilePath);

    $audioStorage
        ->shouldHaveReceived('importAudioFileAs')
        ->with(\Hamcrest\Matchers::equalTo(new AudioFileName('like-you-257s.mp3')), $audioFilePath);
});
