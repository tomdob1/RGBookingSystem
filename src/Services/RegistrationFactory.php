<?php


namespace App\Services;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationFactory implements RegistrationFactoryInterface
{

    public function createEmployee($entityManager, EmployeeTbl $employeeTbl ): Employee {
        return new Employee($entityManager, $employeeTbl);
    }

    public function createOffice( $entityManager, OfficeTbl $officeTbl): Office {
        return new Office($entityManager);
    }


}