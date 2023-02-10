<?php

declare(strict_types=1);

namespace App\Shared\Application;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
class Audio
{
    #[Column()]
    #[Id()]
    public readonly string $id;

    #[Column()]
    public readonly string $title;

    #[Column()]
    public readonly string $extension;

    #[Column()]
    public readonly int $duration;

    #[Column()]
    public readonly string $album;

    public function __construct(
        string $id,
        string $title,
        string $extension,
        int $duration,
        string $album,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->extension = $extension;
        $this->duration = $duration;
        $this->album = $album;
    }
}
