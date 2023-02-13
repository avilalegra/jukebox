<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

class TimeGenerator implements \App\Player\Application\Player\TimeGeneratorInterface
{
    public function epochTime(): int
    {
        return time();
    }
}
