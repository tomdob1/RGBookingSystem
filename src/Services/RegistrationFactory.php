<?php


namespace App\Services;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Interfaces\RegistrationFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\Pure;

class RegistrationFactory implements RegistrationFactoryInterface //abstract factory class used to create employees and offices
{
    public EntityManagerInterface $entityManager;

    /**
     * RegistrationFactory constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param EmployeeTbl $employeeTbl
     * @return Employee
     * creates an employee
     */
    #[Pure] public function createEmployee(EmployeeTbl $employeeTbl ): Employee {
        return new Employee($this->entityManager, $employeeTbl);
    }

    /**
     * @param OfficeTbl $officeTbl
     * @return Office
     * creates an office
     */
    #[Pure] public function createOffice(OfficeTbl $officeTbl): Office {
        return new Office($this->entityManager, $officeTbl);
    }


}