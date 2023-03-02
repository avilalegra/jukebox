<?php

namespace App\Audio\Infrastructure;

use Symfony\Component\Filesystem\Filesystem;

class LocalFileSystem implements LocalFileSystemInterface
{
    public function __construct(
        private Filesystem $filesystem
    )
    {
    }

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


    public function makeTempDir(): string
    {
        $path =  '/tmp/'.time();
        $this->filesystem->mkdir($path);

        return $path;
    }
}