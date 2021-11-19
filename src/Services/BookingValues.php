<?php


namespace App\Services;


final class BookingValues
{
    const CALENDAR = array(
        '08:00' => '08:00',
        '09:00' => '09:00',
        '10:00' => '10:00',
        '11:00' => '11:00',
        '12:00' => '12:00',
        '13:00' => '13:00',
        '14:00' => '14:00',
        '15:00' => '15:00',
        '16:00' => '16:00',
        '17:00' => '17:00'
    );

    const TIMETABLE = array(
        '08:00' => 'Free',
        '09:00' => 'Free',
        '10:00' => 'Free',
        '11:00' => 'Free',
        '12:00' => 'Free',
        '13:00' => 'Free',
        '14:00' => 'Free',
        '15:00' => 'Free',
        '16:00' => 'Free',
        '17:00' => 'Free'
    );

    const TIMETABLE_TEXT = array('Free', 'Booked');


}