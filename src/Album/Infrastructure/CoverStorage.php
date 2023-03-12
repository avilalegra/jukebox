<?php

namespace App\Album\Infrastructure;

use App\Album\Application\CoverStorageInterface;

readonly class CoverStorage implements CoverStorageInterface
{
    public function __construct(
        private string $coversFolder
    )
    {
    }

    public function getCoverFileName(string $albumName): ?string
    {
        $coverPath = $this->coverPath($albumName);
        if (file_exists($coverPath)) {
            return $albumName;
        }

        return null;
    }

    private function coverPath(string $albumName): string
    {
        return $this->coversFolder . '/' . $albumName;
    }
}