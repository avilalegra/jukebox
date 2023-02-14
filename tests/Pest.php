<?php


function testAudioPath(string $fileName): string
{
    $projectDir = test()->getParameter('kernel.project_dir');
    return "{$projectDir}/tests/{$fileName}";
}
