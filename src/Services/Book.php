<?php


namespace App\Services;
use App\Entity\BookTbl;
use App\Entity\EmployeeTbl;
use App\Interfaces\BookInterface;
use Doctrine\ORM\EntityManagerInterface;

class Book implements BookInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager, BookTbl $bookTbl){
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

    public function checkAvailability($officeId, $seatId, $day) : array
    {
        $booking = $this->entityManager->getRepository(BookTbl::class);
        $calendar = $this->compareToCalendar($booking->findSeatAvailability($officeId, $day, $seatId));
        $wholeDayAvailability = $this->checkWholeDayAvailability($calendar);
        return array( 'schedule' => $calendar,
                      'wholeDayAvailable' => $wholeDayAvailability
        );
    }

    private function compareToCalendar($takenSeats) : array
    {
        $calendar = BookingValues::CALENDAR;
        $takenTimes = array();
        foreach($calendar as $cal){
            foreach($takenSeats as $seat){
                if($seat['bookingTime'] == $cal){
                    array_push($takenTimes, $cal);
                }
            }

        }
        return array_diff($calendar, $takenTimes);
    }

    private function checkWholeDayAvailability($calendar){
        if (count(BookingValues::CALENDAR) == count($calendar)){
            return true;
        }
        else {
            return false;
        }
    }

    private function createOneHourBooking($officeId, $seatId, $day, $employeeId, $time, $bookTbl) {
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
            $bookTbl = new BookTbl();
            $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time, $bookTbl);
        }
    }




}