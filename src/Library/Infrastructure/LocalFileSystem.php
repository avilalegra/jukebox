<?php

namespace App\Library\Infrastructure;

use App\Library\Application\FileSystem\LocalFileSystemException;
use App\Library\Application\FileSystem\LocalFileSystemInterface;

class LocalFileSystem implements LocalFileSystemInterface
{

    public function __construct(
        public string $storageFolder
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function writeFile(string $fileName, $contents): void
    {
        try {
            file_put_contents($this->getFilePath($fileName), $contents);
        } catch (\Throwable $t) {
            throw LocalFileSystemException::writeException($fileName, $t);
        }
    }

    public function getFilePath(string $fileName): string
    {
        return $this->storageFolder . '/' . $fileName;
    }
}