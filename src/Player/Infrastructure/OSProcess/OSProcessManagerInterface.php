<?php

namespace App\Player\Infrastructure\OSProcess;

interface OSProcessManagerInterface
{
    /**
     * @throws OsProcessException
     */
    public function kill(int $pid): void;

    /**
     * @throws OsProcessException
     */
    public function run(array $command): void;

    /**
     * @throws OsProcessException
     */
    public function runAsync(array $command): int;
}