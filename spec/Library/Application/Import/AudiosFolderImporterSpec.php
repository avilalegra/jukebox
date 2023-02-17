<?php

namespace spec\App\Library\Application\Import;

use App\Library\Application\Import\AudioImporterInterface;
use App\Library\Application\Import\AudioImportException;
use App\Library\Application\Import\FolderAudiosIterationException;
use App\Library\Application\Import\FolderAudiosIteratorInterface;
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
        AudioImporterInterface        $audioImporter,
        LoggerInterface               $logger
    )
    {
        $this->beConstructedWith($audiosIterator, $audioImporter, $logger);

        $this->importAudios(self::IMPORT_FOLDER);

        foreach (self::EXPECTED_AUDIOS as $path) {
            $audioImporter
                ->importAudio($path)
                ->shouldHaveBeenCalled();
        }
    }

    function it_should_log_errors_when_audio_import_goes_wrong(
        FolderAudiosIteratorInterface $audiosIterator,
        AudioImporterInterface        $audioImporter,
        LoggerInterface               $logger
    )
    {
        $sampleAudioPath = self::IMPORT_FOLDER . "/audio-1.mp3";

        $audioImporter
            ->importAudio(Argument::any())
            ->willThrow(AudioImportException::class);

        $this->beConstructedWith($audiosIterator, $audioImporter, $logger);

        $this->importAudios(self::IMPORT_FOLDER);

        $logger
            ->error("failed to import audio: " . $sampleAudioPath)
            ->shouldHaveBeenCalled();
    }
}
