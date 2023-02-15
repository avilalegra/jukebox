<?php

use App\Library\Application\AudioEntityRepositoryInterface;
use App\Library\Application\GuidGeneratorInterface;
use App\Library\Application\Metadata\AudioMetadata;
use App\Library\Application\Metadata\AudioMetadataExtractorInterface;
use App\Library\Application\Storage\AudioStorageInterface;
use App\Tests\Unit\AudioImporter\AudioImporterTestCase;


uses(AudioImporterTestCase::class);


beforeEach(function () {
    $this->guidGenerator = mock(GuidGeneratorInterface::class)->expect(generateGuid: fn() => SAMPLE_GUID);
    $this->audioStorage = Mockery::spy(AudioStorageInterface::class);
    $this->audioRepository = Mockery::spy(AudioEntityRepositoryInterface::class);
    $this->sampleAudioFilePath = getTestAudioPath('english-course-intro.mp3');
});

test('import audio', function () {
    $metadata = new AudioMetadata(...SAMPLE_AUDIO_METADATA);
    $this->metadataExtractor = mock(AudioMetadataExtractorInterface::class)->expect(extractMetadata: fn($_) => $metadata);
    $importer = $this->makeImporter();

    $importer->importAudio($this->sampleAudioFilePath);

    $this->assertAudioEntityPersisted(SAMPLE_GUID, array_merge(SAMPLE_AUDIO_METADATA));
    $this->assertAudioFileImported('like-you-257s.mp3');
});

test('import audio without title metadata sets filename as title', function () {
    $metadata = new AudioMetadata(...array_merge(SAMPLE_AUDIO_METADATA, ['title' => null]));
    $this->metadataExtractor = mock(AudioMetadataExtractorInterface::class)->expect(extractMetadata: fn($_) => $metadata);
    $importer = $this->makeImporter();

    $importer->importAudio($this->sampleAudioFilePath);

    $this->assertAudioEntityPersisted(SAMPLE_GUID, array_merge(SAMPLE_AUDIO_METADATA, ['title' => 'english-course-intro']));
    $this->assertAudioFileImported('english-course-intro-257s.mp3');
});