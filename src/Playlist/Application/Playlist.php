<?php

namespace App\Playlist\Application;

use App\Shared\Application\Audio;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity()]
readonly class Playlist
{
    #[Column()]
    #[Id()]
    public readonly string $id;

    #[Column()]
    public string $name;

    #[ManyToMany(targetEntity: Audio::class)]
    public Collection $audios;

    public function __construct()
    {
    }
}