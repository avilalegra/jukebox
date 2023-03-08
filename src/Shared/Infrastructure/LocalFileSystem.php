<?php

namespace App\Shared\Infrastructure;

use App\Shared\Application\File\LocalFileSystemInterface;
use Symfony\Component\Filesystem\Filesystem;


readonly class LocalFileSystem implements LocalFileSystemInterface
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

    public function iterateFilesRecursive(string $dirPath): iterable
    {
        $directory = new \RecursiveDirectoryIterator($dirPath);
        $iterator = new \RecursiveIteratorIterator($directory);

        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            if($fileInfo->isFile()){
                yield $fileInfo->getRealPath();
            }
        }
    }

    public function remove(string $targetPath): void
    {
        $this->filesystem->remove($targetPath);
    }
}