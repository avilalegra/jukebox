<?php

namespace App\Library\Application\Import;

interface AudioImporterInterface
{
    /**
     * @throws AudioImportException
     */
    public function importAudio(string $audioFilePath): void;
}