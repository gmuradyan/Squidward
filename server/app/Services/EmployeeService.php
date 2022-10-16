<?php

namespace App\Services;

use App\Interfaces\IEmployeeService;
use App\Interfaces\IFileService;
use App\Interfaces\IMatcherService;

class EmployeeService implements IEmployeeService
{
    protected $file_service;
    protected $matcher_service;

    const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(IFileService $file_service, IMatcherService $matcher_service) {
        $this->file_service = $file_service;
        $this->matcher_service = $matcher_service;
    }

    public function topMatches(string $file_name, string $file) : array  {
        $path = $this->provideEmployeePath().date(self::DATE_FORMAT).$file_name;

        $this->file_service->stroeFile($path, $file);
        $employees = $this->file_service->csvToArray($path);

        return $this->matcher_service->getBestMatches($employees);
    }

    protected function provideEmployeePath() : string {
        return '/employeesCSV/';
    }
}
