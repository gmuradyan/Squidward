<?php

namespace App\Services;

use App\Exceptions\InvalidFileException;
use Illuminate\Support\Facades\Storage;
use App\Interfaces\IFileService;
use Exception;

class FileService implements IFileService
{
    const DELIMITR = ",";
    const SIZE = 1000;

    public function stroeFile(string $path, string $file) : void {
        Storage::disk($this->provideStorige())->put($path, file_get_contents($file), 'public');
    }

    public function csvToArray(string $path) : array {
        $header = null;
        $handle = null;

        try {
            if (($handle = fopen(public_path(). $path, "r")) !== FALSE) {
                $result = [];
                while (($row = fgetcsv($handle, self::SIZE, self::DELIMITR)) !== FALSE) {
                    if (!$header) {
                        $header = $row;
                    }
                    else {
                        $result[] = array_combine($header, $row);
                    }
                }
            }

        } catch (Exception $e) {
            throw new InvalidFileException($e->getMessage());
        } finally {
            fclose($handle);
        }

        return $result;
    }

    protected function provideStorige() : string {
        return 'documents';
    }
}
