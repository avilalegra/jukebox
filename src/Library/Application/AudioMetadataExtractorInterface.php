<?php

namespace App\Library\Application;

interface AudioMetadataExtractorInterface
{
    public function extractMetadata(string $audioFilePath): AudioMetadata;
}