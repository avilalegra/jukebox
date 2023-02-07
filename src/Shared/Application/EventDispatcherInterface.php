<?php

declare(strict_types=1);

namespace App\Shared\Application;

interface EventDispatcherInterface
{
    public function fireEvent(ApplicationEventInterface $event): void;
}
