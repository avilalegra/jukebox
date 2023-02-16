<?php

namespace App\Library\Infrastructure;

use App\Library\Application\Metadata\AudioMetadata;
use App\Library\Application\Metadata\AudioMetadataExtractionException;
use App\Library\Application\Metadata\AudioMetadataExtractorInterface;
use Mhor\MediaInfo\MediaInfo;

class AudioMetadataExtractor implements AudioMetadataExtractorInterface
{

    public function __construct(
        private MediaInfo $mediaInfo
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function extractMetadata(string $audioFilePath): AudioMetadata
    {
        try {
            $info = $this->mediaInfo->getInfo($audioFilePath);
            $general = $info->getGeneral();


            $metadata = new AudioMetadata(
                title: $general->get('title'),
                artist: $general->get('performer'),
                album: $general->get('album'),
                year: $general->get('recorded_date'),
                track: $general->get('track_name_position'),
                genre: $general->get('genre'),
                lyrics: $general->get('lyrics'),
                duration: (int)floor($general->get('duration')->getMilliseconds() / 1000),
                extension: $general->get('file_extension')
            );

            return $metadata;
        } catch (\Throwable $t) {
            throw AudioMetadataExtractionException::forAudioFilePath($audioFilePath, $t);
        }
    }
}