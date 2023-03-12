<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;


class ZipExtractor
{
    public function extract(string $zipFilePath, string $destination): void
    {
        $zip = new \ZipArchive();
        $code = $zip->open($zipFilePath);

        if ($code !== TRUE) {
            throw new \Exception('zip extraction failure');
        }

        $success = $zip->extractTo($destination);

        if (!$success) {
            throw new \Exception('zip extraction failure');
        }

        $success = $zip->close();
        if (!$success) {
            throw new \Exception('zip extraction failure');
        }
    }
}