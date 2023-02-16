<?php

namespace App\Player\Infrastructure\OSProccess;

interface OSProcessRunnerInterface
{
    /**
     * @throws OsProcessException
     */
    public function run(array $command): void;


    public function runAsync(array $command): int;
}