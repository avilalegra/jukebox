<?php

namespace App\Playlist\Domain;

use App\Audio\Domain\AudioEntity;
use Doctrine\Common\Collections\ArrayCollection;
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
#[Table('playlist')]
class PlaylistEntity
{
    #[Column()]
    #[Id()]
    public readonly string $id;

    #[Column()]
    public string $name;

    #[ManyToMany(targetEntity: AudioEntity::class)]
    #[JoinColumn(name: 'playlist_id')]
    #[InverseJoinColumn(name: 'audio_id')]
    #[JoinTable('playlist_audio')]
    public Collection $audios;

    public function __construct(
        string $id,
        string $name,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->audios = new ArrayCollection();
    }

    /**
     * @param array<AudioEntity> $audios
     */
    public function replaceAudios(array $audios): void
    {
        $this->audios->clear();
        foreach ($audios as $audio) {
            $this->audios->add($audio);
        }
    }

    public function readModel(): PlaylistReadModel
    {
        return new PlaylistReadModel(
            id: $this->id,
            name: $this->name,
            audios: $this->audios->map(fn(AudioEntity $a) => $a->readModel())->toArray()
        );
    }
}