<?php

namespace spec\App\Audio\Application\Import;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Application\AudioFileName;
use App\Audio\Application\GuidGeneratorInterface;
use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Metadata\AudioMetadataExtractionException;
use App\Audio\Application\Metadata\AudioMetadataExtractorInterface;
use App\Audio\Application\Storage\AudioStorageException;
use App\Audio\Application\Storage\AudioStorageInterface;
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

        $this->importFrom(self::AUDIO_FILE_PATH);

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

        $this->importFrom(self::AUDIO_FILE_PATH);

        $audioRepository
            ->add($expectedAudio)
            ->shouldHaveBeenCalled();

        $audioStorage
            ->importAudioFileAs(new AudioFileName('like-you-evanescence-257s.mp3'), self::AUDIO_FILE_PATH)
            ->shouldHaveBeenCalled();
    }

    function it_should_throw_exception_when_metadata_extraction_goes_wrong(
        GuidGeneratorInterface          $guidGenerator,
        AudioStorageInterface           $audioStorage,
        AudioMetadataExtractorInterface $metadataExtractor,
        AudioEntityRepositoryInterface  $audioRepository,
    )
    {
        $metadataExtractor
            ->extractMetadata(self::AUDIO_FILE_PATH)
            ->willThrow(AudioMetadataExtractionException::forAudioFilePath(self::AUDIO_FILE_PATH, null));

        $this->beConstructedWith($guidGenerator, $audioStorage, $metadataExtractor, $audioRepository);

        $this->shouldThrow(AudioImportException::class)->duringImportAudio(self::AUDIO_FILE_PATH);
    }

    function it_should_throw_exception_when_storage_import_goes_wrong(
        GuidGeneratorInterface          $guidGenerator,
        AudioStorageInterface           $audioStorage,
        AudioMetadataExtractorInterface $metadataExtractor,
        AudioEntityRepositoryInterface  $audioRepository,
    )
    {
        $audioStorage
            ->importAudioFileAs(new AudioFileName('like-you-evanescence-257s.mp3'), self::AUDIO_FILE_PATH)
            ->willThrow(AudioStorageException::importAudioFileException(self::AUDIO_FILE_PATH, null));

        $this->beConstructedWith($guidGenerator, $audioStorage, $metadataExtractor, $audioRepository);

        $this->shouldThrow(AudioImportException::class)->duringImportAudio(self::AUDIO_FILE_PATH);
    }
}
