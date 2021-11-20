<?php


namespace App\Services;

use App\Interfaces\AvailabilityInterface;
use App\Repository\BookTblRepository;

class Availability implements AvailabilityInterface
{
    private $bookTblRepository;
    public function __construct(BookTblRepository $bookTblRepository){
        $this->bookTblRepository = $bookTblRepository;
    }

    public function checkAvailability($officeId, $seatId, $day) : array
    {
        $calendar = $this->compareToCalendar($this->bookTblRepository->findSeatBookingTimes($seatId, $officeId, $day));
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

    private function checkWholeDayAvailability($calendar): bool
    {
        if (count(BookingValues::CALENDAR) == count($calendar)){
            return true;
        }
        else {
            return false;
        }
    }

}