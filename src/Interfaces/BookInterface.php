<?php


namespace App\Interfaces;


Interface BookInterface
{
    public function addBooking($officeId, $seatId, $day, $employeeEmail, $time = null, $data = 0);



}