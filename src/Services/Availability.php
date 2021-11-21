<?php


namespace App\Services;

use App\Interfaces\AvailabilityInterface;
use App\Repository\BookTblRepository;
use Exception;
use JetBrains\PhpStorm\ArrayShape;

class Availability implements AvailabilityInterface
{
    private BookTblRepository $bookTblRepository;
    public function __construct(BookTblRepository $bookTblRepository){
        $this->bookTblRepository = $bookTblRepository;
    }

    #[ArrayShape(['schedule' => "array", 'wholeDayAvailable' => "bool"])] public function checkAvailability($officeId, $seatId, $day) : array
    {
        $calendar = $this->compareToCalendar($this->bookTblRepository->findSeatBookingTimes($seatId, $officeId, $day));
        $wholeDayAvailability = $this->checkWholeDayAvailability($calendar);
        return array(BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[0] => $calendar,
                     BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[1] => $wholeDayAvailability
        );
    }

    private function compareToCalendar($takenSeats) : array
    {
        $calendar = BookingValues::CALENDAR;
        $takenTimes = array();
        foreach($calendar as $cal){
            foreach($takenSeats as $seat){
                try {
                    if($seat['bookingTime'] == $cal){
                        array_push($takenTimes, $cal);
                    }
                } catch (exception $ex){
                    error_log($ex->getMessage());
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