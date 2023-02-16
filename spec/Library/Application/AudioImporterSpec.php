<?php

namespace spec\App\Library\Application;

use App\Library\Application\AudioEntityRepositoryInterface;
use App\Library\Application\GuidGeneratorInterface;
use App\Library\Application\Metadata\AudioMetadataExtractorInterface;
use App\Library\Application\Storage\AudioStorageInterface;
use App\Shared\Application\AudioFileName;
use PhpSpec\ObjectBehavior;

class AudioImporterSpec extends ObjectBehavior
{
    const AUDIO_FILE_PATH = 'audio/path/Like You Evanescence.mp3';

    function let(GuidGeneratorInterface $guidGenerator,)
    {
        $guidGenerator->generateGuid()->willReturn(SAMPLE_GUID);
    }

    function it_should_import_audio(
        GuidGeneratorInterface          $guidGenerator,
        AudioStorageInterface           $audioStorage,
        AudioMetadataExtractorInterface $metadataExtractor,
        AudioEntityRepositoryInterface  $audioRepository,
    )
    {
        $metadataExtractor
            ->extractMetadata(self::AUDIO_FILE_PATH)
            ->willReturn(sampleMetadata());

        $this->beConstructedWith($guidGenerator, $audioStorage, $metadataExtractor, $audioRepository);

        $this->importAudio(self::AUDIO_FILE_PATH);

        $audioRepository
            ->add(sampleAudioEntity())
            ->shouldHaveBeenCalled();

        $audioStorage
            ->importAudioFileAs(new AudioFileName('like-you-257s.mp3'), self::AUDIO_FILE_PATH)
            ->shouldHaveBeenCalled();
    }

    function it_should_set_filename_as_title_when_there_is_no_title_metadata(
        GuidGeneratorInterface          $guidGenerator,
        AudioStorageInterface           $audioStorage,
        AudioMetadataExtractorInterface $metadataExtractor,
        AudioEntityRepositoryInterface  $audioRepository,
    )
    {
        $expectedAudio = sampleAudioEntity(['title' => 'Like You Evanescence']);

        $metadataExtractor
            ->extractMetadata(self::AUDIO_FILE_PATH)
            ->willReturn(sampleMetadata(['title' => null]));

        $this->beConstructedWith($guidGenerator, $audioStorage, $metadataExtractor, $audioRepository);

        $this->importAudio(self::AUDIO_FILE_PATH);

        $audioRepository
            ->add($expectedAudio)
            ->shouldHaveBeenCalled();

        $audioStorage
            ->importAudioFileAs(new AudioFileName('like-you-evanescence-257s.mp3'), self::AUDIO_FILE_PATH)
            ->shouldHaveBeenCalled();
    }
}
