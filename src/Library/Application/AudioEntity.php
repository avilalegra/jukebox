<?php

namespace App\Library\Application;

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

    public function __construct(
        string $id,
        ?string $title,
        ?string $artist,
        ?string $album,
        ?int $year,
        ?int $track,
        ?string $genre,
        ?string $lyrics,
        ?int $duration
    )
    {
    }
}