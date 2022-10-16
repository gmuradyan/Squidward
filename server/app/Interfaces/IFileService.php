<?php

namespace App\Interfaces;

interface IFileService
{
    public function stroeFile(string $file_name, string $file) : void;

    public function csvToArray(string $file_name) : array;
}
