<?php


namespace App\Services;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use Doctrine\ORM\EntityManagerInterface;

interface RegistrationFactoryInterface
{
    public function createEmployee($entityManager, EmployeeTbl $employeeTbl): Employee;

    public function createOffice($entityManager, OfficeTbl $officeTbl): Office;

}

