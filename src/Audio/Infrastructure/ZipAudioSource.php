<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Import\AudiosSourceInterface;
use App\Shared\Infrastructure\ZipExtractor;

readonly class ZipAudioSource implements AudiosSourceInterface
{
    public function __construct(
        private string                   $zipFilePath,
        private ZipExtractor             $zipExtractor
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
        $success = mkdir($path);
        if (!$success) {
            throw new \Exception("couldn't make temp dir");
        }

        return $path;
    }

    private function iterateFilesRecursive(string $dirPath) : \Generator
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
}