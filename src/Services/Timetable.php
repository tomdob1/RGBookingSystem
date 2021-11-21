<?php


namespace App\Services;

use App\Interfaces\TimetableInterface;
use App\Repository\BookTblRepository;

class Timetable implements TimetableInterface
{
    public $officeId;
    public BookTblRepository $repository;
    public $day;

    /**
     * Timetable constructor.
     * @param $officeId
     * @param $day
     * @param BookTblRepository $repository
     */
    public function __construct($officeId, $day, BookTblRepository $repository){
        $this->officeId = $officeId;
        $this->repository = $repository;
        $this->day = $day;
    }

    /**
     * @param $seatNumber
     * @return array
     * Main function used to obtain the timetable. It checks for the number of seats which have any booking and provides the availability for each one.
     * If there are no bookings whatsoever then the findBookingTimes function is not run.
     */
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

    /**
     * @param $availability
     * @return array
     * Function which takes in the availability to check if any seats are fully booked and to return an array advising which seats have spaces or are fully booked.
     */
    public function fullyBooked($availability): array{
        $fullyBookedArray = array();
        foreach($availability as $av){
           array_push($fullyBookedArray, $this->checkForBookedValue($av));
        }
        return $fullyBookedArray;
    }

    /**
     * @param $seatAvailability
     * @return string
     * Loops through the availability to check for the 'Free' string. If there are none mark that seat as fully booked.
     */
    private function checkForBookedValue($seatAvailability): string {
        foreach($seatAvailability as $availability){
            if($availability == BookingValues::TIMETABLE_TEXT[0]){
                return BookingValues::TIMETABLE_TEXT[0];
            }
        }
        return BookingValues::TIMETABLE_TEXT[1];
    }

    /**
     * @param $seatIds
     * @return array
     * Find the booked times for each seat and add to an array
     */
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

    /**
     * @param $takenSeats
     * @param $seatNumber
     * @return array
     * Create a schedule for the day for each seat
     */
    private function createTimetable($takenSeats, $seatNumber):array{
        $availability = array();
        $calendar = BookingValues::TIMETABLE;
        for($i = 1; $i <= $seatNumber; $i++) {
            $seatId = 'seat' . $i;
            if(isset($takenSeats[$seatId])){ //for each seat replace the free schedule with the booked slots
                $replacedArray = array_replace($calendar, $takenSeats[$seatId]);
            }
            else { //if there are no booked slots add a whole day free schedule to the seat
                $replacedArray = BookingValues::TIMETABLE;
            }
            array_push($availability, $replacedArray); //add seat schedule to the array
        }
      return $availability; //return the schedule for the day
    }


}