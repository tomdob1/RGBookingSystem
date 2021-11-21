<?php


namespace App\Interfaces;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Services\Employee;
use App\Services\Office;
use Doctrine\ORM\EntityManagerInterface;

interface RegistrationFactoryInterface
{
    public function __construct(EntityManagerInterface $entityManager);

    public function createEmployee(EmployeeTbl $employeeTbl): Employee;

    public function createOffice(OfficeTbl $officeTbl): Office;

}

