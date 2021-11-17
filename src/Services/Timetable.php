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
    private $bookingValues = array('Free', 'Booked');

    public function __construct($officeId, BookTblRepository $repository){
        $this->officeId = $officeId;
        $this->repository = $repository;
    }

    public function getNoOfSeats(OfficeTbl $officeTbl): int{
        return $officeTbl->getOfficeSeats();
    }

    public function seatAvailability($seatNumber, $date) : array
    {
         $takenSeats = $this->convertSeatAvailability($this->repository->findTakenSeats($this->officeId, $date));
         return $this->createTimetable($takenSeats, $seatNumber);
    }

    public function getDays():array{
        return $this->days;
    }

    public function getTimeTable(): array{
        return $this->calendar;
    }

    public function convertSeatAvailability($seatAvailability): array
    {
        $takenSeats = array();
        foreach ($seatAvailability as $seat) {
            array_push($takenSeats, array($seat['bookingTime']));
        }

        return $takenSeats;
    }

    private function createTimetable($takenSeats, $seatNumber): array{
        $availability = array();
        for($i = 0; $i <= $seatNumber; $i++ ){
            $seatAdd = array();
           for($j = 0; $j < count($this->calendar); $j++){
               ($this->calendar[$j] == $takenSeats) ? $booking = $this->bookingValues[1] : $booking = $this->bookingValues[0];
                array_push($seatAdd, array($this->calendar[$j] => $booking));
           }
            $availability[$i] = $seatAdd;
        }

        return $availability;
    }

}