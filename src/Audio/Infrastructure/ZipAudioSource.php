<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Import\AudiosSourceInterface;
use App\Shared\Application\File\LocalFileSystemInterface;
use App\Shared\Infrastructure\ZipExtractor;

readonly class ZipAudioSource implements AudiosSourceInterface
{
    public function __construct(
        private string                   $zipFilePath,
        private ZipExtractor             $zipExtractor,
        private LocalFileSystemInterface $localFileSystem,
    )
    {
    }

    public function audioFilePaths(): \Generator
    {
        $tempDirPath = $this->localFileSystem->makeTempDir();
        $this->zipExtractor->extract($this->zipFilePath, $tempDirPath);

        foreach ($this->localFileSystem->iterateFilesRecursive($tempDirPath) as $audioFilePath) {
            yield $audioFilePath;
        }
    }
}