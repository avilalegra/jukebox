<?php

namespace App\Library\Application\Metadata;

interface AudioMetadataExtractorInterface
{
    /**
     * @throws AudioMetadataExtractionException
     */
    public function extractMetadata(string $audioFilePath): AudioMetadata;
}