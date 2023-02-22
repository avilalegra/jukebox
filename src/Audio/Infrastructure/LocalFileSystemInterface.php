<?php

namespace App\Audio\Infrastructure;

interface LocalFileSystemInterface
{
    public function exists(string $filePath): bool;

    /**
     * @throws \Exception
     */
    public function moveFile(string $sourcePath, string $targetPath) : void;
}