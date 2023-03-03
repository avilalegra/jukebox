<?php

namespace App\Player\Infrastructure\OSProccess;

use Symfony\Component\Process\Process;

class OSProcessRunner implements OSProcessRunnerInterface
{
    public static function kill(int $pid): void
    {
        shell_exec("kill {$pid}");
    }

    /**
     * @inheritDoc
     */
    public function run(array $command): void
    {
        $process = $this->createProc($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new OsProcessException($command, $process->getErrorOutput());
        }
    }


    /**
     * @inheritDoc
     */
    public function runAsync(array $command): int
    {
        $process = $this->createProc($command);
        $process->start();

        $pid = $process->getPid();

        if ($pid === null) {
            throw new OsProcessException($command, $process->getErrorOutput());
        }

        return $pid;
    }

    private function createProc(array $command): Process
    {
        $process = new Process($command);
        $process->setOptions(['create_new_console' => true]);
        $process->setTimeout(null);
        $process->setIdleTimeout(null);

        return $process;
    }
}