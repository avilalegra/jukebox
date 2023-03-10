<?php

namespace App\Player\Application\Interactor;

use App\Player\Application\Player\Status\PlayerStatus;

interface PlayerStatusInfoProviderInterface
{
    public function playerStatus() : PlayerStatus;
}