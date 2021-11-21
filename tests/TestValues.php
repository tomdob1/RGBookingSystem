<?php


namespace App\Tests;


use App\Services\BookingValues;

class TestValues //consts used for testing
{
    const OFFICE_ID = 1;
    const SEAT_NO = 1;
    const CORRECT_BOOK_TIMES_REPOSITORY_RESPONSE = array('bookingTime' => '08:00');
    const TIME = '08:00';
    const CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE = array('seatNo' => '1');
    const NOT_FREE_AVAILABILITY = array(
    '08:00' => 'Booked',
    '09:00' => 'Booked',
    '10:00' => 'Booked',
    '11:00' => 'Booked',
    '12:00' => 'Booked',
    '13:00' => 'Booked',
    '14:00' => 'Booked',
    '15:00' => 'Booked',
    '16:00' => 'Booked',
    '17:00' => 'Booked'
);
    const ONE_FREE_AVAILABILITY = array(
        '08:00' => 'Booked',
        '09:00' => 'Booked',
        '10:00' => 'Booked',
        '11:00' => 'Free',
        '12:00' => 'Booked',
        '13:00' => 'Booked',
        '14:00' => 'Booked',
        '15:00' => 'Booked',
        '16:00' => 'Booked',
        '17:00' => 'Booked'
    );
}