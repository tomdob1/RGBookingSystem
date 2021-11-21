<?php


namespace App\Services;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Interfaces\RegistrationFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

class RegistrationFactory implements RegistrationFactoryInterface
{
    public EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Pure] public function createEmployee(EmployeeTbl $employeeTbl ): Employee {
        return new Employee($this->entityManager, $employeeTbl);
    }

    #[Pure] public function createOffice(OfficeTbl $officeTbl): Office {
        return new Office($this->entityManager, $officeTbl);
    }


}