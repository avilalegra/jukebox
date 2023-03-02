<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Metadata\AudioMetadata;
use App\Audio\Application\Metadata\AudioMetadataExtractionException;
use App\Audio\Application\Metadata\AudioMetadataExtractorInterface;
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

            return new AudioMetadata(
                title: $general->get('title'),
                artist: $general->get('performer'),
                album: $general->get('album'),
                year: $general->get('recorded_date'),
                track: $general->get('track_name_position'),
                genre: $general->get('genre'),
                lyrics: $general->get('lyrics'),
                duration: (int)floor($general->get('duration')->getMilliseconds() / 1000),
                extension: 'mp3',
            );
        } catch (\Throwable $t) {
            throw AudioMetadataExtractionException::forAudioFilePath($audioFilePath, $t);
        }
    }
}