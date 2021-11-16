<?php

namespace App\Services;
use App\Entity\EmployeeTbl;
use App\Interfaces;
use Doctrine\ORM\EntityManagerInterface;


class Employee implements Interfaces\EmployeeInterface
{
    public $entityManager;

    public $employeeTbl;


    public function __construct($entityManager, EmployeeTbl $employeeTbl){
            $this->entityManager = $entityManager;
            $this->employeeTbl   = $employeeTbl;
    }

    public function addEmployeeToSystem($task): bool{
        $this->entityManager->persist($task);
        $this->entityManager->flush();
        return true;
    }

}