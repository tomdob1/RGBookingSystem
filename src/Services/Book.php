<?php


namespace App\Services;


use App\Entity\BookTbl;
use App\Interfaces\BookInterface;
use Doctrine\ORM\EntityManagerInterface;

class Book implements BookInterface
{
    private $entityManager;
    private $bookTbl;
    public function __construct(EntityManagerInterface $entityManager, BookTbl $bookTbl){
        $this->entityManager = $entityManager;
        $this->bookTbl = $bookTbl;
    }

    public function createOneHourBooking($officeId, $seatId, $day, $employeeId, $time): bool {

        $this->bookTbl->setOfficeId($officeId);
        $this->bookTbl->setSeatNo($seatId);
        $this->bookTbl->setBookingDate($day);
        $this->bookTbl->setBookingTime($time);
        $this->bookTbl->setEmployeeId($employeeId);
        $this->entityManager->persist($this->bookTbl);
        $this->entityManager->flush();
        return true;
    }

    public function createWholeDayBooking($officeId, $seatId, $day, $employeeId, $time ='08:00'): bool
    {
        for ($i = 0; $i <= 8; $i++){
            $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time);
        }
        return true;
    }


}