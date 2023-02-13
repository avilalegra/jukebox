<?php

namespace App\Tests;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[\AllowDynamicProperties]
abstract class IntegrationTestBase extends KernelTestCase
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