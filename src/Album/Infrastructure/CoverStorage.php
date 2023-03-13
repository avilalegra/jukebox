<?php

namespace App\Album\Infrastructure;

use App\Album\Application\CoverStorageInterface;
use Symfony\Component\Filesystem\Filesystem;

readonly class CoverStorage implements CoverStorageInterface
{
    public function __construct(
        private string     $coversFolder,
        private Filesystem $filesystem
    )
    {
    }

    public function getCoverFileName(string $albumName): ?string
    {
        $coverPath = $this->coverPath($albumName);
        if ($this->filesystem->exists($coverPath)) {
            return $albumName;
        }

        return null;
    }

    private function coverPath(string $albumName): string
    {
        return $this->coversFolder . '/' . $albumName;
    }
}