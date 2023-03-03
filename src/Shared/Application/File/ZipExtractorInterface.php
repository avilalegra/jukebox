<?php

namespace App\Shared\Application\File;

interface ZipExtractorInterface
{
    public function extract(string $zipFilePath, string $destination): void;
}