<?php

use App\Library\Application\Metadata\AudioMetadata;
use App\Library\Application\Metadata\AudioMetadataExtractionException;
use App\Library\Infrastructure\AudioMetadataExtractor;
use App\Tests\Integration\IntegrationTestCase;
use Mhor\MediaInfo\Exception\UnknownTrackTypeException;
use Mhor\MediaInfo\MediaInfo;

uses(IntegrationTestCase::class);


beforeEach(function () {
    $this->extractor = new AudioMetadataExtractor(new MediaInfo());
});

test('extract audio metadata when metadata exists', function () {
    $metadata = $this->extractor->extractMetadata(getTestAudioPath('taking-over.mp3'));

    expect($metadata)
        ->toEqualCanonicalizing(
            new AudioMetadata(...SAMPLE_AUDIO_METADATA));
});


test('extract audio metadata when no metadata exists', function () {
    $metadata = $this->extractor->extractMetadata(getTestAudioPath('english-course-intro.mp3'));

    expect($metadata)
        ->toEqualCanonicalizing(
            new AudioMetadata(
                title: null,
                artist: null,
                album: null,
                year: 2014,
                track: 1,
                genre: null,
                lyrics: null,
                duration: 16,
                extension: 'mp3'
            ));
});


it('throws exception', function () {
    $mediaInfoMock = mock(MediaInfo::class)
        ->expect(getInfo: fn($_) => throw new UnknownTrackTypeException('track type value'));

    $extractor = new AudioMetadataExtractor($mediaInfoMock);
    $extractor->extractMetadata(getTestAudioPath('english-course-intro.mp3'));

})->throws(AudioMetadataExtractionException::class);