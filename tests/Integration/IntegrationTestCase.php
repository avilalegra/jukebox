<?php

namespace App\Tests\Integration;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[\AllowDynamicProperties]
abstract class IntegrationTestCase extends KernelTestCase
{
    public function container() : ContainerInterface
    {
        return static::getContainer();
    }

    public function getParameter(string $name)
    {
        return static::getContainer()->getParameter($name);
    }
}