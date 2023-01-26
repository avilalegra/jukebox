<?php

declare(strict_types=1);

namespace App\Player\Application;

interface PlayerStatusRepositoryInterface
{
    public function saveCurrentStatus(PlayerStatus $playerStatus) : void;

    public function getCurrentStatus() : PlayerStatus;
}