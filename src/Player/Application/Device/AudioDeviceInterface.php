<?php

declare(strict_types=1);

namespace App\Player\Application\Device;

use App\Shared\Domain\AudioReadModel;

interface AudioDeviceInterface
{
    /** @throws AudioDeviceException */
    public function play(AudioReadModel $audio): void;
}