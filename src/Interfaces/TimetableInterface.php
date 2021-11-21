<?php


namespace App\Interfaces;


use App\Repository\BookTblRepository;

interface TimetableInterface
{

    public function __construct($officeId, $day, BookTblRepository $repository);

    public function getTimetable($seatNumber) : array;

    public function fullyBooked($availability): array;

}