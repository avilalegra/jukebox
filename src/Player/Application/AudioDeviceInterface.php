<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Application\AudioReadModel;

interface AudioDeviceInterface
{
    /** @throws AudioDeviceException */
    public function play(AudioReadModel $audio): void;
}
