<?php


use App\Library\Infrastructure\FolderAudiosIterator;

test('iterate mp3 audios', function () {
    $iterator = new FolderAudiosIterator();

    $paths = iterator_to_array($iterator->iterateAudios(projectDir()));

    expect($paths)->toEqualCanonicalizing([
        testAudioPath('english-course-intro.mp3'),
        testAudioPath('taking-over.mp3')
    ]);
});