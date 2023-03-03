<?php

namespace App\Player;

class PlayerException extends \Exception
{
    public function __construct(
        string      $message,
        ?\Throwable $previous = null
    )
    {
        parent::__construct($message, 2, $previous);
    }
}