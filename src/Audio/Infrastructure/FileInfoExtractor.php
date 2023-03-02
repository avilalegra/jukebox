<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Import\FileInfoExtractorInterface;
use Symfony\Component\Process\Process;

class FileInfoExtractor implements FileInfoExtractorInterface
{
    public function fileNameWithoutExtension(string $filePath): string
    {
        return explode('.', basename($filePath))[1];
    }

    public function mimeType(string $filePath): string
    {
        $process = new Process(['file', '-b', '--mime-type', $filePath]);
        $process->run();
        return trim($process->getOutput());
    }
}