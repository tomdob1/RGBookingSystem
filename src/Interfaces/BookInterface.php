<?php


namespace App\Interfaces;


Interface BookInterface
{
    public function addBooking($officeId, $seatId, $day, $employeeEmail, $time = null, $data = 0);

    public function checkAvailability($officeId, $seatId, $day): array;

}