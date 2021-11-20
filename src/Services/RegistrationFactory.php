<?php


namespace App\Services;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Interfaces\RegistrationFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
class RegistrationFactory implements RegistrationFactoryInterface
{
    public $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createEmployee(EmployeeTbl $employeeTbl ): Employee {
        return new Employee($this->entityManager, $employeeTbl);
    }

    public function createOffice( OfficeTbl $officeTbl): Office {
        return new Office($this->entityManager);
    }


}