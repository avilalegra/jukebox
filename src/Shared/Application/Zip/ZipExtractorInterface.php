<?php

namespace App\Shared\Application\Zip;

interface ZipExtractorInterface
{
    public function extract(string $zipFilePath, string $destination): void;
}