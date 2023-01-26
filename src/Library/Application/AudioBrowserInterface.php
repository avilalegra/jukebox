<?php

declare(strict_types=1);

namespace App\Library\Application;

use App\Shared\Application\Album;

interface AudioBrowserInterface
{
    /**
     * @return array<Album>
     */
    public function allAlbums() : array;

}