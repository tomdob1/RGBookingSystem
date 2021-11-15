<?php


namespace App\Classes;

use App\Entity\OfficeTbl;
use Doctrine\ORM\EntityManagerInterface;

class Office
{
    /**
     * @var OfficeTbl
     */
    private $officeTable;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(OfficeTbl $officeTable, EntityManagerInterface $entityManager){
        $this->officeTable   = $officeTable;
        $this->entityManager = $entityManager;
    }

    public function loopOffices($officeNumber, $seats ): bool {
        for($i = 0; $i < $officeNumber; $i++){
            $this->addOffice($seats);
        }
        return true;
    }

    private function addOffice($seats) : bool {
        $this->officeTable->setOfficeSeats($seats);
        $this->entityManager->persist($this->officeTable);
        $this->entityManager->flush();
        return true;
    }

}