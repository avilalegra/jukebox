<?php

namespace App\Playlist\Application;

use App\Shared\Application\AudioReadModel;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
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

    #[ManyToMany(targetEntity: AudioReadModel::class)]
    #[InverseJoinColumn(name: 'audio_id')]
    #[JoinTable('playlist_audio')]
    public Collection $audios;

    public function __construct()
    {
    }
}