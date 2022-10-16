<?php

namespace App\Interfaces;

interface IEmployeeService
{
    public function topMatches(string $file_name, string $file) : array;
}
