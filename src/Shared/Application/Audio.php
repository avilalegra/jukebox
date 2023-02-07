<?php

declare(strict_types=1);

namespace App\Shared\Application;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('audios')]
class Audio
{
    #[Column('id')]
    #[Id()]
    public readonly int $id;

    #[Column('name')]
    public readonly string $name;

    #[Column('extension')]
    public readonly string $ext;

    #[Column('duration')]
    public readonly int $secDuration;

    #[ManyToOne(targetEntity: Album::class, inversedBy: 'audios')]
    public readonly Album $album;

    public function __construct(
        int $id,
        string $name,
        string $ext,
        int $secDuration
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->ext = $ext;
        $this->secDuration = $secDuration;
    }
}
