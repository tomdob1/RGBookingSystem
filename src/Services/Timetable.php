<?php


namespace App\Services;

use App\Repository\BookTblRepository;

class Timetable
{
    public $officeId;
    public $repository;
    public $day;

    public function __construct($officeId, $day, BookTblRepository $repository){
        $this->officeId = $officeId;
        $this->repository = $repository;
        $this->day = $day;
    }

    public function getTimetable($seatNumber) : array
    {
        $takenSeats = $this->repository->findTakenSeats($this->officeId, $this->day);
        if($takenSeats){
            $bookingTimes = $this->findBookingTimes($takenSeats);
        }
        else {
            $bookingTimes = null;
        }

         return $this->createTimetable($bookingTimes, $seatNumber);
    }

    public function fullyBooked($availability): array{
        $fullyBookedArray = array();
        foreach($availability as $av){
           array_push($fullyBookedArray, $this->checkForBookedValue($av));
        }
        return $fullyBookedArray;
    }

    private function checkForBookedValue($seatAvailability): string {
        foreach($seatAvailability as $availability){
            if($availability == BookingValues::TIMETABLE_TEXT[0]){
                return BookingValues::TIMETABLE_TEXT[0];
            }
        }
        return BookingValues::TIMETABLE_TEXT[1];
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
            $seatName = 'seat' . $seatId['seatNo'];
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
                $replacedArray = array_replace($calendar, $takenSeats[$seatId]);
            }
            else {
                $replacedArray = BookingValues::TIMETABLE;
            }
            array_push($availability, $replacedArray);
        }
      return $availability;
    }


}