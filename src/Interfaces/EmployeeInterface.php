<?php


namespace App\Interfaces;


use App\Entity\EmployeeTbl;
use Doctrine\ORM\EntityManagerInterface;

interface EmployeeInterface
{
    public function __construct($entityManager, EmployeeTbl $employeeTbl);

    public function addEmployeeToSystem($task): bool;

}

