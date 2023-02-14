<?php


function resourceFromContents(string $contents)
{
    $audioStream = fopen('php://temp/maxmemory:4M', 'r+');
    fwrite($audioStream, $contents);
    rewind($audioStream);
    return $audioStream;
}
