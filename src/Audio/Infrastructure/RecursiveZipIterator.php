<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Import\FileInfoExtractorInterface;
use App\Audio\Application\Import\ZipIteratorInterface;

class RecursiveZipIterator implements ZipIteratorInterface
{

    public function __construct(
        private LocalFileSystemInterface   $localFileSystem,
        private FileInfoExtractorInterface $fileInfoExtractor,
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function iterateZipFiles(string $zipFilePath): iterable
    {
        $extractionDir = $this->localFileSystem->makeTempDir();

        $zip = new \ZipArchive();

        if ($zip->open($zipFilePath) !== TRUE) {
            throw new \Exception('zip iteration failure');
        }

        $zip->extractTo($extractionDir);
        $zip->close();

        return $this->iterateDirRecursive($extractionDir);
    }


    private function iterateDirRecursive(string $dirPath): iterable
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