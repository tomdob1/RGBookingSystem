<?php


namespace App\Interfaces;


use Doctrine\ORM\EntityManagerInterface;

Interface BookInterface
{
    public function __construct(EntityManagerInterface $entityManager);

    public function addBooking($officeId, $seatId, $day, $employeeEmail, $time = null, $data = 0);



}