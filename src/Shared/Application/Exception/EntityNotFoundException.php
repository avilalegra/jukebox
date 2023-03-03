<?php

namespace App\Shared\Application\Exception;

class EntityNotFoundException extends \Exception
{
    public function __construct(
        public string $class,
        public string $entityId,
    )
    {
        parent::__construct("entity of type $this->class and id {$this->entityId} was not found");
    }
}