<?php

namespace App\Library\Application\FileSystem;

interface LocalFileSystemInterface
{
    /**
     * @param resource $contents
     * @throws LocalFileSystemException
     */
    public function writeFile(string $fileName,  $contents): void;

    public function getFilePath(string $fileName) : string;
}