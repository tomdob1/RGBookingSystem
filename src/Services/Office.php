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
    private EntityManagerInterface $entityManager;
    private OfficeTbl $officeTbl;

    public function __construct(EntityManagerInterface $entityManager, OfficeTbl $officeTbl){
        $this->officeTbl     = $officeTbl;
        $this->entityManager = $entityManager;
    }

    public function addOffices($officeNumber, $seat): void {
        for($i = 0; $i < $officeNumber; $i++){
            $this->saveOffice($seat);
        }
    }

    public function saveOffice($seat): void  {
        $this->officeTbl->setOfficeSeats($seat);
        $this->entityManager->persist($this->officeTbl);
        $this->entityManager->flush();
    }

}