<?php


namespace App\Interfaces;


use App\Entity\OfficeTbl;
use Doctrine\ORM\EntityManagerInterface;

interface OfficesInterface
{
    public function addOffices($officeNumber, $seat): void;

    public function saveOffice($seat) : void;

}