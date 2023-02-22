<?php

namespace App\Audio\Application;

use App\Audio\Domain\AudioEntity;

interface AudioEntityRepositoryInterface
{
    public function add(AudioEntity $audio) : void;

    public function find(string $audioId) : AudioEntity;
}