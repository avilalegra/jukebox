<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;


class ZipExtractor
{
    public function extract(string $zipFilePath, string $destination): void
    {
        $zip = new \ZipArchive();
        $zip->open($zipFilePath) === TRUE || $this->throwFailure();
        $zip->extractTo($destination) || $this->throwFailure();
        $zip->close() || $this->throwFailure();
    }

    private function throwFailure(): never
    {
        throw new \Exception('zip extraction failure');
    }
}