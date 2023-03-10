<?php

namespace App\Audio\Application;

use App\Audio\Domain\AudioEntity;
use App\Audio\Domain\AudioReadModel;

interface AudioEntityRepositoryInterface
{
    public function add(AudioEntity $audio) : void;

    public function find(string $audioId) : AudioEntity;

    public function hasOneWithSameTitleAndDuration(AudioEntity $audio) : bool;

    public function remove(AudioEntity $audio): void;
}