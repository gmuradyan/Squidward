<?php

namespace App\Interfaces;

interface IMatcherService
{
    public function getBestMatches(array $employees) : array;
}
