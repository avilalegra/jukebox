<?php

namespace App\Shared\Application\File;

interface FileInfoExtractorInterface
{
    public function fileNameWithoutExtension(string $filePath) : string;

    public function mimeType(string $filePath) : string;
}