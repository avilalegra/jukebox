<?php

declare(strict_types=1);

namespace App\Shared\Application;

interface ApplicationEventInterface
{
    public static function name(): string;
}
