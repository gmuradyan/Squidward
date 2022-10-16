<?php

namespace App\Api\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\GetEmployees;
use App\Interfaces\IEmployeeService;
use App\Exceptions\InternalErrorException;
use App\Exceptions\InvalidCountException;
use App\Exceptions\InvalidFileException;
use Exception;

class EmployeeController extends BaseController
{
    protected $employee_service;

    public function __construct(IEmployeeService $employee_service) {
        $this->employee_service = $employee_service;
    }

    public function topMatches(GetEmployees $request) : JsonResponse {
        try {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();

            $top = $this->employee_service->topMatches($file_name, $file);

            return response()->json($top);
        } catch (InvalidFileException $e) {
            throw $e;
        } catch (InvalidCountException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new InternalErrorException($e->getMessage());
        }
    }
}
