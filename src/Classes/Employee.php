<?php

namespace App\Classes;
use App\Entity\EmployeeTbl;
use App\Interfaces;
use Doctrine\ORM\EntityManagerInterface;


class Employee implements Interfaces\EmployeeInterface
{
    public function addEmployeeToSystem($firstName, $lastName, $employeeNo, $email, EmployeeTbl $employeeTable, EntityManagerInterface $entityManager): bool{

        $employeeTable->setFirstName($firstName);
        $employeeTable->setLastName($lastName);
        $employeeTable->setPayrollNo($employeeNo);
        $employeeTable->setEmail($email);
        $entityManager->persist($employeeTable);
        $entityManager->flush();

        return true;
    }

}