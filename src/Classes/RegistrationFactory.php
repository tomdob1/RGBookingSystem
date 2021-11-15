<?php


namespace App\Classes;


class RegistrationFactory implements RegistrationFactoryInterface
{

    public function createEmployee($firstName, $lastName, $employeeNo, $email): Employee {
        return new Employee;
    }

    public function createOffice($officeNumber, $seatNumber): Office {
        return new Office;
    }


}