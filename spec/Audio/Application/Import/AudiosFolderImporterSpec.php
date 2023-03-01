<?php

namespace spec\App\Audio\Application\Import;

use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\FolderAudiosIteratorInterface;
use App\Audio\Application\Import\Strategy\AudioImportStrategyInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class AudiosFolderImporterSpec extends ObjectBehavior
{
    const IMPORT_FOLDER = 'import/folder/path';

    const EXPECTED_AUDIOS = [
        self::IMPORT_FOLDER . "/audio-1.mp3",
        self::IMPORT_FOLDER . "/audio-2.mp3",
        self::IMPORT_FOLDER . "/audio-3.mp3",
    ];

    function let(
        FolderAudiosIteratorInterface $audiosIterator,
    )
    {
        $audiosIterator
            ->iterateAudios(self::IMPORT_FOLDER)
            ->willReturn(self::EXPECTED_AUDIOS);
    }

    function it_should_import_all_audios(
        FolderAudiosIteratorInterface $audiosIterator,
        AudioImportStrategyInterface  $audioImporter,
        LoggerInterface               $logger
    )
    {
        $this->beConstructedWith($audiosIterator, $audioImporter, $logger);

        $this->importAudios(self::IMPORT_FOLDER);

        foreach (self::EXPECTED_AUDIOS as $path) {
            $audioImporter
                ->import($path)
                ->shouldHaveBeenCalled();
        }
    }

    function it_should_log_errors_when_audio_import_goes_wrong(
        FolderAudiosIteratorInterface $audiosIterator,
        AudioImportStrategyInterface  $audioImporter,
        LoggerInterface               $logger
    )
    {
        $sampleAudioPath = self::IMPORT_FOLDER . "/audio-1.mp3";

        $audioImporter
            ->import(Argument::any())
            ->willThrow(AudioImportException::class);

        $this->beConstructedWith($audiosIterator, $audioImporter, $logger);

        $this->importAudios(self::IMPORT_FOLDER);

        $logger
            ->error("failed to import audio: " . $sampleAudioPath)
            ->shouldHaveBeenCalled();
    }
}
