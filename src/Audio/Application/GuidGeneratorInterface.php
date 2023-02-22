<?php

namespace App\Audio\Application;

interface GuidGeneratorInterface
{
    public function generateGuid() : string;
}