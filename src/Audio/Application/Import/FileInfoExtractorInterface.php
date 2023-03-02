<?php

namespace App\Audio\Application\Import;

interface FileInfoExtractorInterface
{
    public function fileNameWithoutExtension(string $filePath) : string;

    public function mimeType(string $filePath) : string;
}