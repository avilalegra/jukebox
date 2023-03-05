<?php

namespace App\Audio\Application;

use App\Audio\Domain\AudioEntity;
use App\Shared\Application\Exception\EntityNotFoundException;

interface AudioEntityRepositoryInterface
{
    public function add(AudioEntity $audio) : void;

    public function find(string $audioId) : AudioEntity;
}