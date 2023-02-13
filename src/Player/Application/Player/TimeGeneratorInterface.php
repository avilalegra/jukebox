<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

interface TimeGeneratorInterface
{
    public function epochTime(): int;
}
