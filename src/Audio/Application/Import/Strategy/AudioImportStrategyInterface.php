<?php

namespace App\Audio\Application\Import\Strategy;

use App\Audio\Application\Import\AudiosImportResult;

interface AudioImportStrategyInterface
{

    public function canImport(string $filePath) : bool;

    public function import(string $filePath): AudiosImportResult;
}