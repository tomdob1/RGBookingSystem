<?php


namespace App\Interfaces;


Interface AvailabilityInterface
{
    public function checkAvailability($officeId, $seatId, $day): array;
}