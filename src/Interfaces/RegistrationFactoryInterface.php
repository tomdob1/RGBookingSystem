<?php


namespace App\Interfaces;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Services\Employee;
use App\Services\Office;

interface RegistrationFactoryInterface
{
    public function createEmployee(EmployeeTbl $employeeTbl): Employee;

    public function createOffice(OfficeTbl $officeTbl): Office;

}

