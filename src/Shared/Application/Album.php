<?php

declare(strict_types=1);

namespace App\Shared\Application;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

readonly class Album
{
    public function __construct(
        public string $name,
        public array $audios
    )
    {
    }
}
