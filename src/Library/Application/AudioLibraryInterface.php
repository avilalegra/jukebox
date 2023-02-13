<?php

declare(strict_types=1);

namespace App\Library\Application;


interface AudioLibraryInterface
{
    /**
     * @return array<string>
     */
    public function albumNamesIndex(): array;
}
