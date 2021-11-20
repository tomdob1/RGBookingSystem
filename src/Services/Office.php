<?php


namespace App\Services;

use App\Entity\OfficeTbl;
use App\Interfaces\OfficesInterface;
use Doctrine\ORM\EntityManagerInterface;

class Office implements OfficesInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;
    }

    public function addOffices($officeNumber, $seat): void {
        for($i = 0; $i < $officeNumber; $i++){
            $this->saveOffice($seat);
        }
    }

    public function saveOffice($seat): void  {
        $officeTable = new OfficeTbl();
        $officeTable->setOfficeSeats($seat);
        $this->entityManager->persist($officeTable);
        $this->entityManager->flush();
    }

}