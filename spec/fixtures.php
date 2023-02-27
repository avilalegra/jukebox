<?php

use App\Audio\Application\Metadata\AudioMetadata;
use App\Audio\Domain\AudioEntity;
use App\Audio\Domain\AudioReadModel;


const SAMPLE_GUID = 'c1bc7bd8-be49-477e-9d72-38cc385c8bbf';

function sampleAudioEntity(array $overwrites = []): AudioEntity
{
    return new AudioEntity(
        SAMPLE_GUID,
        ...array_merge(METADATA, $overwrites));
}

function sampleAudioReadModel(array $overwrites = []): AudioReadModel
{
    return new AudioReadModel(
        SAMPLE_GUID,
        ...array_merge(METADATA, $overwrites));
}

function sampleMetadata(array $overwrites = []): AudioMetadata
{
    return new AudioMetadata(
        ...array_merge(METADATA, $overwrites));
}

const METADATA = [
    'title' => 'Like You',
    'artist' => 'Evanescence',
    'album' => 'The Open Door',
    'year' => '2006',
    'track' => 8,
    'genre' => 'Alternative Rock',
    'lyrics' => "Stay low / Soft, dark, and dreamless / Far beneath my nightmares and loneliness / I hate me for breathing without you / I don't want to feel anymore for you /  / Grieving for you / I'm not grieving for you / Nothing real love can't undo / And though I may have lost my way / All paths lead straight to you /  / I long to be like you / Lie cold in the ground like you /  / Halo / Blinding wall between us / Melt away and leave us alone again / Humming, haunted somewhere out there / I believe our love can see us through in death /  / I long to be like you / Lie cold in the ground like you / There's room inside for two / And I'm not grieving for you / I'm coming for you /  / You're not alone / No matter what they told you, you're not alone / I'll be right beside you forevermore /  / I long to be like you, sis / Lie cold in the ground like you did / There's room inside for two / And I'm not grieving for you / And as we lay in silent bliss / I know you remember me /  / I long to be like you / Lie cold in the ground like you / There's room inside for two / And I'm not grieving for you / I'm coming for you",
    'duration' => 257,
    'extension' => 'mp3'
];