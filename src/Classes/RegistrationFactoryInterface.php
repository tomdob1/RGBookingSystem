<?php


namespace App\Classes;


interface RegistrationFactoryInterface
{
    public function createEmployee($firstName, $lastName, $employeeNo, $email): Employee;

    public function createOffice($officeNumber, $seatNumber): Office;

}

