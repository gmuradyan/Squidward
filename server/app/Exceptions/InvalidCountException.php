<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

class InvalidCountException extends NotAcceptableHttpException
{
    public function __construct($message = 'Not acceptable item count exception')
    {
        parent::__construct($message, null);
    }
}
