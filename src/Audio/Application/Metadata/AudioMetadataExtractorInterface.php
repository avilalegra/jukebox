<?php

namespace App\Audio\Application\Metadata;

interface AudioMetadataExtractorInterface
{
    /**
     * @throws AudioMetadataExtractionException
     */
    public function extractMetadata(string $audioFilePath): AudioMetadata;
}