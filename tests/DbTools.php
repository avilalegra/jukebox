<?php

namespace App\Tests;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

trait DbTools
{
    public function em(): EntityManagerInterface
    {
        return $this->getContainer()->get(EntityManagerInterface::class);
    }

    public function connection(): Connection
    {
        return $this->em()->getConnection();
    }
}