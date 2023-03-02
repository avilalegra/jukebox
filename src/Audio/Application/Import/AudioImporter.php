<?php

namespace App\Audio\Application\Import;

use App\Audio\Application\Import\Strategy\AudioImportStrategyInterface;
use App\Audio\Application\Import\Strategy\SingleAudioImportStrategy;
use App\Audio\Application\Interactor\AudioImporterInterface;

class AudioImporter implements AudioImporterInterface
{

    /**
     * @var SingleAudioImportStrategy[]|array
     */
    private array $importStrategies;

    public function __construct(
        SingleAudioImportStrategy $singleAudioImportStrategy
    )
    {
        $this->importStrategies = [$singleAudioImportStrategy];
    }


    /**
     * @inheritDoc
     */
    public function import(string $filePath): AudiosImportResult
    {
        foreach ($this->importStrategies as $importStrategy) {
            if ($importStrategy->canImport($filePath)) {
                return $importStrategy->import($filePath);
            }
        }
        throw new AudioImportException($filePath);
    }
}