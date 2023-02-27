<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Domain\AudioReadModel;

interface AudioInfoProviderInterface
{
    public function findAudio(string $audioId): AudioReadModel;

    /**
     * @return array<AudioReadModel>
     */
    public function paginateAudios() : array;
}