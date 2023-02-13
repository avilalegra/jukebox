<?php

use App\Library\Application\FileSystem\LocalFileSystemException;
use App\Library\Infrastructure\LocalFileSystem;
use App\Tests\IntegrationTestBase;

uses(IntegrationTestBase::class);

test('get stored file path', function () {
    $fs = new LocalFileSystem('folder');
    expect($fs->getFilePath('sample.mp3'))->toEqual('folder/sample.mp3');
});

test('write file', function () {
    $storageFolder = $this->getParameter('storage_folder');
    $fs = new LocalFileSystem($storageFolder);

    $fs->writeFile('file.txt', resourceFromContents('sample file contents'));

    $filePath = $fs->getFilePath('file.txt');
    expect(file_exists($filePath))->toBeTrue();
    unlink($filePath);
});


it('throws write exception', function () {
    $fs = new LocalFileSystem('not found folder');
    $fs->writeFile('sample.mp3', resourceFromContents('sample contents'));
})->throws(LocalFileSystemException::class);

function resourceFromContents(string $contents)
{
    $audioStream = fopen('php://temp/maxmemory:4M', 'r+');
    fwrite($audioStream, $contents);
    rewind($audioStream);
    return $audioStream;
}
