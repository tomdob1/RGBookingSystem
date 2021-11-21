<?php


namespace App\Services;

use App\Interfaces\AvailabilityInterface;
use App\Repository\BookTblRepository;
use Exception;
use JetBrains\PhpStorm\ArrayShape;

class Availability implements AvailabilityInterface
//class which obtains the availability of a particular seat with the intention to only populate the booking form time input with options which have not been taken
{
    private BookTblRepository $bookTblRepository;
    public function __construct(BookTblRepository $bookTblRepository){
        $this->bookTblRepository = $bookTblRepository;
    }

    /**
     * @param $officeId
     * @param $seatId
     * @param $day
     * @return array
     * Returns an array containing the availability of a specific seat within an office on a particular day.
     * Within that array contains an array which advises whether a whole day is available or not.
     */
    #[ArrayShape(['schedule' => "array", 'wholeDayAvailable' => "bool"])] public function checkAvailability($officeId, $seatId, $day) : array
    {
        $calendar = $this->compareToCalendar($this->bookTblRepository->findSeatBookingTimes($seatId, $officeId, $day)); //runs a db query to obtain the booking times for a particular seat. Passes it into a function to compare against schedule.
        $wholeDayAvailability = $this->checkWholeDayAvailability($calendar);
        return array(BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[0] => $calendar,
                     BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[1] => $wholeDayAvailability
        );
    }

    /**
     * @param $takenSeats
     * @return array
     * Takes the booking times of a particular seat and removes them from the calendar array. This creates a list of times which are free to book.
     */
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

    /**
     * @param $calendar
     * @return bool
     * Checks to see if a whole day is available
     */
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