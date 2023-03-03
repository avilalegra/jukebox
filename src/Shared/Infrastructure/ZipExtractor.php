<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Application\File\ZipExtractorInterface;


class ZipExtractor implements ZipExtractorInterface
{

    public function extract(string $zipFilePath, string $destination): void
    {
        $zip = new \ZipArchive();
        $code = $zip->open($zipFilePath);

        if ($code !== TRUE) {
            throw new \Exception('zip iteration failure');
        }

        $zip->extractTo($destination);
        $zip->close();
    }
}