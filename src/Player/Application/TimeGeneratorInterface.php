<?php

declare(strict_types=1);

namespace App\Player\Application;

interface TimeGeneratorInterface
{
    public function epochTime(): int;
}
