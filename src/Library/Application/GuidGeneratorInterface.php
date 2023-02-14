<?php

namespace App\Library\Application;

interface GuidGeneratorInterface
{
    public function generateGuid() : string;
}