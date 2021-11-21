<?php


namespace App\Tests;


use App\Repository\BookTblRepository;
use App\Services\BookingValues;
use App\Services\Timetable;
use PHPUnit\Util\Test;

class TimetableTest extends \PHPUnit\Framework\TestCase
{
    public function mockBookTblRepository($response): BookTblRepository|\PHPUnit\Framework\MockObject\MockObject
    {
        $repository = $this->getMockBuilder(BookTblRepository::class)->disableOriginalConstructor()->getMock();
        $repository->expects($this->any())
            ->method('findTakenSeats')
            ->willReturn($response);

        $repository->expects($this->any())
            ->method('findSeatBookingTimes')
            ->willReturn(array(TestValues::CORRECT_BOOK_TIMES_REPOSITORY_RESPONSE));

        return $repository;
    }

    public function testGetTimetableWithTakenSeats(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));
        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        self::assertIsArray($timetable->getTimetable(TestValues::SEAT_NO), 'testGetTimetableWithTakenSeats does not return an array');
    }

    public function testGetTimetableWithNoTakenSeats(){
        $repository = $this->mockBookTblRepository(null);
        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);

        self::assertIsArray($timetable->getTimetable(TestValues::SEAT_NO), 'testGetTimetableWithNoTakenSeats does not return an array');
    }

    public function testTimetableTimesMatch(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));

        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        $result    = $timetable->getTimetable(TestValues::SEAT_NO);
        foreach(BookingValues::CALENDAR as $cal){
            self::assertArrayHasKey($cal , $result[0], 'testTimetableTimesMatch do not match');
        }
    }

    public function testTimeTableContainsFree(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));

        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        $result    = $timetable->getTimetable(TestValues::SEAT_NO);
            self::assertEquals(BookingValues::TIMETABLE_TEXT[0] , $result[0]['09:00'], 'testTimeTableContainsFree does not have a result of free');
    }

    public function testTimeTableContainsBooked(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));

        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        $result    = $timetable->getTimetable(TestValues::SEAT_NO);
        self::assertEquals(BookingValues::TIMETABLE_TEXT[1] , $result[0]['08:00'], 'testTimeTableContainsBooked does not have a result of booked');
    }

    public function testFullyBookedFreeAvailability(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));
        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        $result    = $timetable->fullyBooked(array(BookingValues::TIMETABLE));
        self::assertEquals(BookingValues::TIMETABLE_TEXT[0], $result[0], 'testFullyBookedFreeAvailability is not completely free when expected to be');
    }

    public function testFullyBookedNotFreeAvailability(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));
        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        $result    = $timetable->fullyBooked(array(TestValues::NOT_FREE_AVAILABILITY));
        self::assertEquals(BookingValues::TIMETABLE_TEXT[1], $result[0], 'testFullyBookedFreeAvailability is display free when it should not be');
    }

    public function testFullyBookedOneFreeAvailability(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));
        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        $result    = $timetable->fullyBooked(array(TestValues::ONE_FREE_AVAILABILITY));
        self::assertEquals(BookingValues::TIMETABLE_TEXT[0], $result[0], 'testFullyBookedOneFreeAvailability should display free although it does not');
    }

    public function testFullyBookedReturnsArray(){
        $repository = $this->mockBookTblRepository(array(TestValues::CORRECT_TAKEN_SEATS_BOOK_REPOSITORY_RESPONSE));
        $timetable = new Timetable(TestValues::OFFICE_ID, BookingValues::WORKING_DAYS[0], $repository);
        $result    = $timetable->fullyBooked(array(TestValues::ONE_FREE_AVAILABILITY));
        self::assertIsArray($result, 'testFullyBookedReturnsArray is not an array');
    }







}