<?php

namespace spec\App\Library\Infrastructure;

use Mhor\MediaInfo\MediaInfo;
use PhpSpec\ObjectBehavior;

class AudioMetadataExtractorSpec extends ObjectBehavior
{
    function it_should_extract_metadata()
    {
        $this->beConstructedWith(new MediaInfo());

        $this
            ->extractMetadata(__DIR__ . '/like-you.mp3')
            ->shouldBeLike(sampleMetadata());
    }
}
