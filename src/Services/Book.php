<?php


namespace App\Services;
use App\Entity\BookTbl;
use App\Entity\EmployeeTbl;
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

    public function addBooking($data, $officeId, $seatId, $day, $employeeEmail, $time = null){
        $employee = $this->entityManager->getRepository(EmployeeTbl::class)->find($employeeEmail);
        $employeeId = $employee->getId();
        if ($data > 1) {
            $this->createWholeDayBooking($officeId, $seatId, $day, $employeeId);
        }
        else if ($data == 1){
            $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time);
        }
    }

    public function checkAvailability($officeId, $seatId, $day) : array
    {
        $booking = $this->entityManager->getRepository(BookTbl::class);
        $takenSeats = $booking->findSeatAvailability($officeId, $day, $seatId);
        $calendar = $this->compareToCalendar($takenSeats);
        $wholeDayAvailability = $this->checkWholeDayAvailability($calendar);
        return array( 'schedule' => $calendar,
                      'wholeDayAvailable' => $wholeDayAvailability
        );
    }

    private function compareToCalendar($takenSeats) : array
    {
        $calendar = BookingValues::CALENDAR;

        foreach($calendar as $cal){
            foreach($takenSeats as $seat){
                if($seat == $cal){
                    unset($cal[$seat]);
                }
            }
        }
        return $calendar;
    }

    private function checkWholeDayAvailability($calendar){
        if (count(BookingValues::CALENDAR) == count($calendar)){
            return true;
        }
        else {
            return false;
        }
    }

    private function createOneHourBooking($officeId, $seatId, $day, $employeeId, $time): bool {

        $this->bookTbl->setOfficeId($officeId);
        $this->bookTbl->setSeatNo($seatId);
        $this->bookTbl->setBookingDate($day);
        $this->bookTbl->setBookingTime($time);
        $this->bookTbl->setEmployeeId($employeeId);
        $this->entityManager->persist($this->bookTbl);
        $this->entityManager->flush();
        return true;
    }

    private function createWholeDayBooking($officeId, $seatId, $day, $employeeId): bool
    {
        $time = '08:00';
        for ($i = 0; $i <= 8; $i++){
            $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time);
        }
        return true;
    }




}