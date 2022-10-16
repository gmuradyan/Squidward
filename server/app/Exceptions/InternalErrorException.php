<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class InternalErrorException extends BadRequestHttpException
{
    public function __construct($message = 'Internal error exception')
    {
        parent::__construct($message, null);
    }
}
