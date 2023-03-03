<?php

namespace App\Audio\Application\Import\Strategy;


use App\Audio\Application\Import\AudioImportException;
use App\Audio\Application\Import\AudiosImportResult;

interface AudioImportStrategyInterface
{

    public function canImport(string $filePath) : bool;

    /**
     * @throws AudioImportException
     */
    public function import(string $filePath): AudiosImportResult;
}