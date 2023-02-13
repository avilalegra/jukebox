<?php

namespace App\Library\Application;

interface AudioEntityRepositoryInterface
{
    public function add(AudioEntity $audio) : void;
}