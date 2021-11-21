<?php


namespace App\Services;

use App\Entity\OfficeTbl;
use App\Interfaces\OfficesInterface;
use Doctrine\ORM\EntityManagerInterface;

class Office implements OfficesInterface
{

    private EntityManagerInterface $entityManager;

    /**
     * Office constructor.
     * @param EntityManagerInterface $entityManager
     * @param OfficeTbl $officeTbl
     */
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }



    /**
     * @param $officeNumber
     * @param $seat
     * checks to see how many offices were added and loops through the save office function
     */
    public function addOffices($officeNumber, $seat): void {
        for($i = 0; $i < $officeNumber; $i++){
            $this->saveOffice($seat);
        }
    }

    /**
     * @param $seat
     * Saves an office with the specified number of seats
     */
    public function saveOffice($seat): void  {
        $officeTbl = new OfficeTbl();
        $officeTbl->setOfficeSeats($seat);
        $this->entityManager->persist($officeTbl);
        $this->entityManager->flush();
    }

}