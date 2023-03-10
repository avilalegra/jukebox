<?php

namespace App\Audio\Application\Import;


use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

readonly class AudioImporter
{

    public function __construct(
        #[TaggedIterator('audio.import_strategy')]
        private iterable $importStrategies
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