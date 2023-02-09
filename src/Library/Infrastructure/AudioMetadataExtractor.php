<?php

namespace App\Library\Infrastructure;

use App\Library\Application\AudioMetadata;
use App\Library\Application\AudioMetadataExtractorInterface;
use Mhor\MediaInfo\MediaInfo;

class AudioMetadataExtractor implements AudioMetadataExtractorInterface
{
    public function __construct(
        private MediaInfo $mediaInfo
    )
    {
    }

    public function extractMetadata(string $audioFilePath): AudioMetadata
    {
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
            duration: (int)floor($general->get('duration')->getMilliseconds() / 1000)
        );

        return $metadata;
    }
}