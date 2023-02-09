<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

#[\AllowDynamicProperties]
class JukeboxTestBase extends KernelTestCase
{
    public function getParameter(string $name)
    {
        return static::getContainer()->getParameter($name);
    }
}