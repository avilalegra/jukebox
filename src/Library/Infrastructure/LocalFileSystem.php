<?php

namespace App\Library\Infrastructure;

class LocalFileSystem implements LocalFileSystemInterface
{
    /**
     * @inheritDoc
     */
    public function exists(string $filePath): bool
    {
        return file_exists($filePath);
    }

    public function moveFile(string $sourcePath, string $targetPath): void
    {
        $h = fopen($sourcePath, 'r');
        file_put_contents($targetPath, $h);
    }
}