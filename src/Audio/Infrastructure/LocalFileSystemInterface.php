<?php

namespace App\Audio\Infrastructure;

interface LocalFileSystemInterface
{
    public function exists(string $filePath): bool;

    /**
     * @throws \Exception
     */
    public function moveFile(string $sourcePath, string $targetPath) : void;

    public function makeTempDir() : string;

    public function iterateFilesRecursive(string $dirPath): iterable;
}