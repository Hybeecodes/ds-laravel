<?php

namespace App\Exceptions;

use Exception;

class ValidationFailedException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('User not found');
    }
}
