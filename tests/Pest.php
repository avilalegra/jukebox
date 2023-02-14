<?php


function testAudioPath(string $fileName): string
{
    return __DIR__ . "/{$fileName}";
}

function projectDir(): string
{
    return __DIR__;
}
