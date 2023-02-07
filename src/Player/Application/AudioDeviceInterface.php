<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Application\Audio;

interface AudioDeviceInterface
{
    /** @throws AudioDeviceException */
    public function play(Audio $audio): void;
}
