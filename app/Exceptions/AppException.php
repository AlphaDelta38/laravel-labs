<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    public function __construct($message = "An unexpected error occurred", $code = 500)
    {
        parent::__construct($message, $code);
    }
}
