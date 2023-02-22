<?php

namespace App\Audio\Application\Import;

interface AudioImporterInterface
{
    /**
     * @throws AudioImportException
     */
    public function importAudio(string $audioFilePath): void;
}