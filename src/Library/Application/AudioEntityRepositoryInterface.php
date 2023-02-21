<?php

namespace App\Library\Application;

use App\Library\Domain\AudioEntity;

interface AudioEntityRepositoryInterface
{
    public function add(AudioEntity $audio) : void;

    public function find(string $audioId) : AudioEntity;
}