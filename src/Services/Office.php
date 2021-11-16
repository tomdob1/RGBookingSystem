<?php


namespace App\Services;

use App\Entity\OfficeTbl;
use Doctrine\ORM\EntityManagerInterface;

class Office
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;
    }

    public function loopOffices($officeNumber, $seats): bool {
        for($i = 0; $i < $officeNumber; $i++){
            $this->addOffice($seats);
        }


        return true;
    }

    private function addOffice($seats): void  {
        $officeTable = new OfficeTbl();
        $officeTable->setOfficeSeats($seats);
        $this->entityManager->persist($officeTable);
        $this->entityManager->flush();
    }

}