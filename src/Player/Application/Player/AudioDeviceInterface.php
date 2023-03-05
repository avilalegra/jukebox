<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Audio\Domain\AudioReadModel;

interface AudioDeviceInterface
{
    public function play(AudioReadModel $audio): void;
}
