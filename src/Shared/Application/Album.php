<?php

declare(strict_types=1);

namespace App\Shared\Application;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('albums')]
class Album
{
    #[Column()]
    #[Id()]
    public readonly int $id;

    #[Column]
    public readonly string $name;

    #[OneToMany(mappedBy: 'album', targetEntity: Audio::class)]
    public readonly Collection $audios;

    public function __construct()
    {
        $this->audios = new ArrayCollection();
    }
}
