<?php

namespace spec\App\Audio\Infrastructure;

use App\Audio\Application\AudioFileName;
use App\Audio\Application\Storage\AudioStorageException;
use App\Shared\Application\File\LocalFileSystemInterface;
use PhpSpec\ObjectBehavior;

class AudioStorageSpec extends ObjectBehavior
{
    const STORAGE_PATH = __DIR__;
    const IMPORTED_AUDIO_PATH = 'audio/path/Like You.mp3';

    function let(LocalFileSystemInterface $localFileSystem)
    {
        $this->beConstructedWith(self::STORAGE_PATH, $localFileSystem);
    }

    function it_should_import_audio_file(LocalFileSystemInterface $localFileSystem)
    {
        $this->importAudioFileAs(
            new AudioFileName('like-you-16s.mp3'),
            self::IMPORTED_AUDIO_PATH
        );

        $localFileSystem
            ->moveFile(self::IMPORTED_AUDIO_PATH, self::STORAGE_PATH . '/like-you-16s.mp3')
            ->shouldHaveBeenCalled();
    }

    function it_should_get_full_path_audio(
        LocalFileSystemInterface $localFileSystem
    )
    {
        $localFileSystem
            ->exists(self::STORAGE_PATH . '/like-you-16s.mp3')
            ->willReturn(true);

        $this->beConstructedWith(self::STORAGE_PATH, $localFileSystem);

        $this->getFullPath(new AudioFileName('like-you-16s.mp3'))
            ->shouldReturn(self::STORAGE_PATH . '/like-you-16s.mp3');

    }

    function it_should_throw_exception_when_getting_path_of_non_existing_audio(
        LocalFileSystemInterface $localFileSystem
    )
    {
        $localFileSystem
            ->exists(self::STORAGE_PATH . '/like-you-16s.mp3')
            ->willReturn(false);

        $this->beConstructedWith(self::STORAGE_PATH, $localFileSystem);

        $this->shouldThrow(AudioStorageException::class)
            ->duringGetFullPath(new AudioFileName('like-you-16s.mp3'));
    }
}
