<?php

namespace App\Audio\Domain;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;


#[Entity()]
#[Table('audio', uniqueConstraints: [new UniqueConstraint(columns: ['title', 'duration'])])]
class AudioEntity
{
    public static function fromReadModel(AudioReadModel $audio): self
    {
        return new self(
            id: $audio->id,
            title: $audio->title,
            artist: $audio->artist,
            album: $audio->album,
            year: $audio->year,
            track: $audio->track,
            genre: $audio->genre,
            lyrics: $audio->lyrics,
            duration: $audio->duration
        );
    }

    #[Column()]
    #[Id()]
    public readonly string $id;

    #[Column(nullable: true)]
    private ?string $title;
    #[Column(nullable: true)]
    private ?string $artist;

    #[Column(nullable: true)]
    private ?string $album;
    #[Column(nullable: true)]
    private ?string $year;
    #[Column(nullable: true)]
    private ?int $track;
    #[Column(nullable: true)]
    private ?string $genre;
    #[Column(nullable: true)]
    private ?string $lyrics;

    #[Column(nullable: true)]
    private ?int $duration;

    public function __construct(
        string  $id,
        ?string $title,
        ?string $artist,
        ?string $album,
        ?string $year,
        ?int    $track,
        ?string $genre,
        ?string $lyrics,
        ?int    $duration
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
        );
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function duration(): ?int
    {
        return $this->duration;
    }
}