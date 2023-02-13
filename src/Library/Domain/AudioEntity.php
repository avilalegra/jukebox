<?php

namespace App\Library\Domain;

use App\Shared\Domain\AudioReadModel;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
#[Table('audio')]
class AudioEntity
{
    #[Column()]
    #[Id()]
    public readonly string $id;
    #[Column()]
    private ?string $title;
    #[Column()]
    private ?string $artist;

    #[Column()]
    private ?string $album;
    #[Column()]
    private ?int $year;
    #[Column()]
    private ?int $track;
    #[Column()]
    private ?string $genre;
    #[Column()]
    private ?string $lyrics;
    #[Column()]
    private ?int $duration;

    #[Column()]
    private string $extension;

    public function __construct(
        string  $id,
        ?string $title,
        ?string $artist,
        ?string $album,
        ?int    $year,
        ?int    $track,
        ?string $genre,
        ?string $lyrics,
        ?int    $duration,
        string  $extension
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->artist = $artist;
        $this->album = $album;
        $this->year = $year;
        $this->track = $track;
        $this->genre = $genre;
        $this->lyrics = $lyrics;
        $this->duration = $duration;
        $this->extension = $extension;
    }

    public function readModel(): AudioReadModel
    {
        return new AudioReadModel(
            id: $this->id,
            title: $this->title,
            artist: $this->artist,
            album: $this->album,
            year: $this->year,
            track: $this->track,
            genre: $this->genre,
            lyrics: $this->lyrics,
            duration: $this->duration,
            extension: $this->extension
        );
    }
}