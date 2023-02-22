<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\GuidGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class GuidGenerator implements GuidGeneratorInterface
{
    public function generateGuid(): string
    {
        return Uuid::v4();
    }
}