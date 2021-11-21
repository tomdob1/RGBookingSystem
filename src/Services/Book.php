<?php


namespace App\Services;
use App\Entity\BookTbl;
use App\Entity\EmployeeTbl;
use App\Interfaces\BookInterface;
use Doctrine\ORM\EntityManagerInterface;

class Book implements BookInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function addBooking($officeId, $seatId, $day, $employeeEmail, $time = null, $data = 0){
        $employee = $this->entityManager->getRepository(EmployeeTbl::class)->find($employeeEmail);
        $employeeId = $employee->getId();

            if ($data == 1) {
                $this->createWholeDayBooking($officeId, $seatId, $day, $employeeId);
            }
            else if ($data == 0){
                $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time);
            }
    }

    private function createOneHourBooking($officeId, $seatId, $day, $employeeId, $time) {
        $bookTbl = new BookTbl();
        $bookTbl->setOfficeId($officeId);
        $bookTbl->setSeatNo($seatId);
        $bookTbl->setBookingDate($day);
        $bookTbl->setBookingTime($time);
        $bookTbl->setEmployeeId($employeeId);
        $this->entityManager->persist($bookTbl);
        $this->entityManager->flush();
    }

    private function createWholeDayBooking($officeId, $seatId, $day, $employeeId)
    {
        foreach(BookingValues::CALENDAR as $time){
            $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time);
        }
    }




}