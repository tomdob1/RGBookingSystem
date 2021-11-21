<?php


namespace App\Interfaces;


use App\Repository\BookTblRepository;

Interface AvailabilityInterface
{
    public function __construct(BookTblRepository $bookTblRepository);

    public function checkAvailability($officeId, $seatId, $day): array;
}