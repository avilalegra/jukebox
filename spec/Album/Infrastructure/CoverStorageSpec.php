<?php

namespace spec\App\Album\Infrastructure;


use App\Library\Infrastructure\LocalFileSystemInterface;
use PhpSpec\ObjectBehavior;

class CoverStorageSpec extends ObjectBehavior
{
    const COVERS_FOLDER = __DIR__;
    const SAMPLE_ALBUM_NAME = 'Evanescence';

    function it_should_return_cover_filename_if_it_exists(
        LocalFileSystemInterface $localFileSystem
    )
    {
        $localFileSystem->exists(self::COVERS_FOLDER . '/' . self::SAMPLE_ALBUM_NAME)->willReturn(true);
        $this->beConstructedWith(self::COVERS_FOLDER, $localFileSystem);

        $this->searchCoverFileName(self::SAMPLE_ALBUM_NAME)->shouldReturn(self::SAMPLE_ALBUM_NAME);
    }

    function it_should_return_null_if_cover_doesnt_exists(
        LocalFileSystemInterface $localFileSystem
    )
    {
        $localFileSystem->exists(self::COVERS_FOLDER . '/' . self::SAMPLE_ALBUM_NAME)->willReturn(false);
        $this->beConstructedWith(self::COVERS_FOLDER, $localFileSystem);

        $this->searchCoverFileName(self::SAMPLE_ALBUM_NAME)->shouldReturn(null);
    }
}
