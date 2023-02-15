<?php


function getTestAudioPath(string $fileName): string
{
    return __DIR__ . "/{$fileName}";
}

function projectDir(): string
{
    return __DIR__;
}


function dataPatcher(array $default)
{
    return fn(array $overwrites = []) => array_merge($default, $overwrites);
}
