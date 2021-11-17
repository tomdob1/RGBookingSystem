<?php


namespace App\Interfaces;


use App\Entity\BookTbl;
use Doctrine\ORM\EntityManagerInterface;

Interface BookInterface
{

    public function createOneHourBooking($officeId, $seatId, $day, $employeeId, $time) : bool;

    public function createWholeDayBooking($officeId, $seatId, $day, $employeeId, $time) : bool;
}