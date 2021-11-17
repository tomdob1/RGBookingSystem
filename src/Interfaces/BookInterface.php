<?php


namespace App\Interfaces;


Interface BookInterface
{
    public function addBooking($data, $officeId, $seatId, $day, $employeeId, $time = null);

    public function checkAvailability($officeId, $seatId, $day): array;

}