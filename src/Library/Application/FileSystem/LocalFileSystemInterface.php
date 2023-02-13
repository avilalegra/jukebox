<?php

namespace App\Library\Application\FileSystem;

interface LocalFileSystemInterface
{
    /**
     * @param resource $contents
     * @throws LocalFileSystemException
     */
    public function writeFile(string $fileName,  $contents): void;

    /**
     * @throws LocalFileSystemException
     */
    public function getExistingFilePath(string $fileName) : string;
}