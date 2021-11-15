<?php


namespace App\Interfaces;


use App\Entity\OfficeTbl;
use Doctrine\ORM\EntityManagerInterface;

interface OfficesInterface
{
    public function loopOffices($officeNumber, $seat): bool;

    public function addOffice($seats, OfficeTbl $officeTable, EntityManagerInterface $entityManager) : bool;

}