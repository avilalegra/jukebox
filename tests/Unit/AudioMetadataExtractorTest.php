<?php

use App\Library\Application\Metadata\AudioMetadata;
use App\Library\Application\Metadata\AudioMetadataExtractionException;
use App\Library\Infrastructure\AudioMetadataExtractor;
use App\Tests\IntegrationTestBase;
use Mhor\MediaInfo\Exception\UnknownTrackTypeException;
use Mhor\MediaInfo\MediaInfo;

uses(IntegrationTestBase::class);


beforeEach(function () {
    $this->extractor = new AudioMetadataExtractor();
});

test('extract audio metadata when metadata exists', function () {
    $metadata = $this->extractor->extractMetadata(testAudioPath('taking-over.mp3'));

    expect($metadata)
        ->toEqualCanonicalizing(
            new AudioMetadata(
                title: 'Like You',
                artist: 'Evanescence',
                album: 'The Open Door',
                year: 2006,
                track: 8,
                genre: 'Alternative Rock',
                lyrics: "Stay low / Soft, dark, and dreamless / Far beneath my nightmares and loneliness / I hate me for breathing without you / I don't want to feel anymore for you /  / Grieving for you / I'm not grieving for you / Nothing real love can't undo / And though I may have lost my way / All paths lead straight to you /  / I long to be like you / Lie cold in the ground like you /  / Halo / Blinding wall between us / Melt away and leave us alone again / Humming, haunted somewhere out there / I believe our love can see us through in death /  / I long to be like you / Lie cold in the ground like you / There's room inside for two / And I'm not grieving for you / I'm coming for you /  / You're not alone / No matter what they told you, you're not alone / I'll be right beside you forevermore /  / I long to be like you, sis / Lie cold in the ground like you did / There's room inside for two / And I'm not grieving for you / And as we lay in silent bliss / I know you remember me /  / I long to be like you / Lie cold in the ground like you / There's room inside for two / And I'm not grieving for you / I'm coming for you",
                duration: 257,
                extension: 'mp3'
            ));
});



test('extract audio metadata when no metadata exists', function () {
    $metadata = $this->extractor->extractMetadata(testAudioPath('english-course-intro.mp3'));

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
    $extractor->extractMetadata(testAudioPath('english-course-intro.mp3'));

})->throws(AudioMetadataExtractionException::class);