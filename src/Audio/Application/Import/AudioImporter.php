<?php

namespace App\Audio\Application\Import;


use App\Audio\Application\Interactor\AudioImporterInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class AudioImporter implements AudioImporterInterface
{

    public function __construct(
        #[TaggedIterator( 'audio.import_strategy')] private iterable $importStrategies
    )
    {
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