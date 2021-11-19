<?php


namespace App\Services;


use App\Entity\OfficeTbl;

use App\Repository\BookTblRepository;
use Doctrine\Persistence\ObjectRepository;

class Timetable
{
    private $officeId;
    public $repository;
    private $dayTimetable = array(
        'dateBegin' => '08:00',
        'dateEnd'   => '17:00'
    );
    private $days = array(
        'monday', 'tuesday', 'wednesday', 'thursday', 'friday'
    );
    private $calendar = array(
        '08:00',
        '09:00',
        '10:00',
        '11:00',
        '12:00',
        '13:00',
        '14:00',
        '15:00',
        '16:00',
        '17:00',
    );
    private $day;


    public function __construct($officeId, $day, BookTblRepository $repository){
        $this->officeId = $officeId;
        $this->repository = $repository;
        $this->day = $day;
    }

    public function getNoOfSeats(OfficeTbl $officeTbl): int{
        return $officeTbl->getOfficeSeats();
    }

    public function seatAvailability($seatNumber) : array
    {
        $takenSeats = $this->repository->findTakenSeats3($this->officeId, $this->day);
        if($takenSeats){
            $bookingTimes = $this->findBookingTimes($takenSeats);
        }
        else {
            $bookingTimes = null;
        }

         return $this->createTimetable($bookingTimes, $seatNumber);
    }

    public function getDays():array{
        return $this->days;
    }

    public function getTimeTable(): array{
        return $this->calendar;
    }


    private function findBookingTimes($seatIds) : array
    {
        $bookingTimes = array();
        $i = 0;
        foreach($seatIds as $seatId){
            $time = array();
            $i++;
            $seatTimes = $this->repository->findSeatBookingTimes($seatId, $this->officeId, $this->day);
            foreach($seatTimes as $seatTime){
                $time = array_merge($time, array($seatTime['bookingTime'] => BookingValues::TIMETABLE_TEXT[1]));
            }
            $seatName = 'seat' . $i;
            $bookingTimes = array_merge($bookingTimes, array($seatName => $time));
        }
        return $bookingTimes;
    }

    private function createTimetable($takenSeats, $seatNumber):array{
        $availability = array();
        $calendar = BookingValues::TIMETABLE;
        for($i = 1; $i <= $seatNumber; $i++) {
            $seatId = 'seat' . $i;
            if(isset($takenSeats[$seatId])){
                $test = array_replace($calendar, $takenSeats[$seatId]);
            }
            else {
                $test = BookingValues::TIMETABLE;
            }
            array_push($availability, $test);
        }
      return $availability;
    }


}