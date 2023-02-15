<?php


use App\Library\Infrastructure\FolderAudiosIterator;

test('iterate mp3 audios', function () {
    $iterator = new FolderAudiosIterator();

    $paths = iterator_to_array($iterator->iterateAudios(projectDir()));

    expect($paths)->toEqualCanonicalizing([
        getTestAudioPath('english-course-intro.mp3'),
        getTestAudioPath('taking-over.mp3')
    ]);
});