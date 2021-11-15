<?php


namespace App\Interfaces;


use App\Entity\EmployeeTbl;
use Doctrine\ORM\EntityManagerInterface;

interface EmployeeInterface
{
    public function addEmployeeToSystem($firstName, $lastName, $employeeNo, $email, EmployeeTbl $employeeTable, EntityManagerInterface $entityManager): bool;

}

