<?php

namespace App\Album\Infrastructure;

use App\Album\Application\CoverStorageInterface;
use App\Library\Infrastructure\LocalFileSystemInterface;

class CoverStorage implements CoverStorageInterface
{
    public function __construct(
        private string $coversFolder,
        private LocalFileSystemInterface $localFileSystem
    )
    {
    }

    public function searchCoverFileName(string $albumName): ?string
    {
        $coverPath = $this->coverPath($albumName);
        if ($this->localFileSystem->exists($coverPath)) {
            return $albumName;
        }
        return null;
    }

    private function coverPath(string $albumName): string
    {
        return $this->coversFolder . '/' . $albumName;
    }
}