<?php

namespace App\Player\Infrastructure;

use Symfony\Component\Process\Process;

class OSProcessManager
{

    public function kill(int $pid): void
    {
        $this->run(['kill', $pid]);
    }


    public function run(array $command): void
    {
        $process = $this->createProc($command);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->throwProcessFailure($process);
        }
    }


    public function runAsync(array $command): int
    {
        $process = $this->createProc($command);
        $process->start();

        $pid = $process->getPid();

        if ($pid === null) {
            $this->throwProcessFailure($process);
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

    private function throwProcessFailure(Process $process): never
    {
        throw new \Exception(message: 'os process execution failure', previous: new \Exception($process->getErrorOutput()));
    }
}