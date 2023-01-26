<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use App\Shared\Application\ApplicationEventInterface;
use App\Shared\Application\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

class SymfonyEventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        private SymfonyEventDispatcherInterface $dispatcher
    )
    {
    }


    public function fireEvent(ApplicationEventInterface $event): void
    {
        $this->dispatcher->dispatch($event, $event::name());
    }
}
