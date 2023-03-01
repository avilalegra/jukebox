<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;

interface AudioImporterInterface
{
    /**
     * @throws AudioImportException
     */
    public function importFrom(string $filePath) : AudiosImportResult;
}