<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Import\AudiosSourceInterface;
use App\Shared\Infrastructure\ZipExtractor;
use Symfony\Component\Filesystem\Filesystem;

readonly class ZipAudioSource implements AudiosSourceInterface
{
    public function __construct(
        private string       $zipFilePath,
        private ZipExtractor $zipExtractor,
        private Filesystem   $filesystem
    )
    {
    }

    public function audioFilePaths(): \Generator
    {
        $tempDirPath = $this->makeTempDir();
        $this->zipExtractor->extract($this->zipFilePath, $tempDirPath);
        return $this->iterateFilesRecursive($tempDirPath);
    }

    private function makeTempDir(): string
    {
        $path = '/tmp/' . time();
        $this->filesystem->mkdir($path);
        return $path;
    }

    private function iterateFilesRecursive(string $dirPath): \Generator
    {
        $directory = new \RecursiveDirectoryIterator($dirPath);
        $iterator = new \RecursiveIteratorIterator($directory);

        /** @var \SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isFile()) {
                yield $fileInfo->getRealPath();
            }
        }
    }
}