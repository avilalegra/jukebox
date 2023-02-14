<?php

use App\Library\Application\FileSystem\LocalFileSystemException;
use App\Library\Infrastructure\LocalFileSystem;
use App\Tests\IntegrationTestBase;

uses(IntegrationTestBase::class);

test('get stored file path', function () {
    $storageFolder = $this->getParameter('kernel.project_dir').'/tests';
    $fs = new LocalFileSystem($storageFolder);
    expect($fs->getExistingFilePath('taking-over.mp3'))->toEqual($storageFolder.'/taking-over.mp3');
});



it('throws get not existent file path exception', function() {
    $storageFolder = $this->getParameter('storage_folder');
    $fs = new LocalFileSystem($storageFolder);

    $fs->getExistingFilePath('not_found_file');

})->throws(LocalFileSystemException::class);



test('write file', function () {
    $storageFolder = $this->getParameter('storage_folder');
    $fs = new LocalFileSystem($storageFolder);

    $fs->writeFile('file.txt', resourceFromContents('sample file contents'));

    $filePath = $fs->getExistingFilePath('file.txt');
    expect(file_exists($filePath))->toBeTrue();
    unlink($filePath);
});



it('throws write exception', function () {
    $fs = new LocalFileSystem('not found folder');
    $fs->writeFile('sample.mp3', resourceFromContents('sample contents'));
})->throws(LocalFileSystemException::class);


