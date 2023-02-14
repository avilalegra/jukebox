<?php

namespace App\Library\Infrastructure;

use App\Library\Application\GuidGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class GuidGenerator implements GuidGeneratorInterface
{
    public function generateGuid(): string
    {
        return Uuid::v4();
    }
}