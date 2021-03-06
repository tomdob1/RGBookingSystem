<?php


namespace App\Tests;


use App\Repository\BookTblRepository;
use App\Services\Availability;
use App\Services\BookingValues;

class AvailabilityTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param $response
     * @return BookTblRepository|\PHPUnit\Framework\MockObject\MockObject
     * Used to return a repository
     */
    public function mockBookTblRepository($response): BookTblRepository|\PHPUnit\Framework\MockObject\MockObject
    {
        $repository = $this->getMockBuilder(BookTblRepository::class)->disableOriginalConstructor()->getMock();
        $repository->expects($this->any())
            ->method('findSeatBookingTimes')
            ->willReturn(array($response));
        return $repository;

    }

    /**
     * Tests to see if the array for CheckAvailable keys match correctly
     */
    public function testSuccessfulCheckAvailableKeys(){
        $availability = new Availability($this->mockBookTblRepository(TestValues::CORRECT_BOOK_TIMES_REPOSITORY_RESPONSE));
        self::assertArrayHasKey(BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[0], $availability->checkAvailability(TestValues::OFFICE_ID, TestValues::SEAT_NO, BookingValues::WORKING_DAYS[1]), 'First array key does not match');
        self::assertArrayHasKey(BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[1], $availability->checkAvailability(TestValues::OFFICE_ID, TestValues::SEAT_NO, BookingValues::WORKING_DAYS[1]), 'Second array key does not match');
    }

    /**
     * Tests to see if an array is returned for CheckAvailable
     */
    public function testSuccessfulCheckAvailableTimeTable(){
        $availability = new Availability($this->mockBookTblRepository(TestValues::CORRECT_BOOK_TIMES_REPOSITORY_RESPONSE));
        $result = $availability->checkAvailability(TestValues::OFFICE_ID, TestValues::SEAT_NO, BookingValues::WORKING_DAYS[1]);
        self::assertIsArray($result[BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[0]], 'Schedule has not returned as an array');
    }

    /**
     * Tests to see if the WholeDayAvailable value returns a boolean in CheckAvailable function
     */
    public function testSuccessfulCheckAvailableWholeDayBoolean(){
        $availability = new Availability($this->mockBookTblRepository(TestValues::CORRECT_BOOK_TIMES_REPOSITORY_RESPONSE));
        $result = $availability->checkAvailability(TestValues::OFFICE_ID, TestValues::SEAT_NO, BookingValues::WORKING_DAYS[1]);
        self::assertIsBool($result[BookingValues::RETURNED_TIMETABLE_ARRAY_KEYS[1]], 'Day availability does not return a boolean');
    }

    /**
     * Tests to check that the length of the array returned is correct
     */
    public function testSuccessfulCheckAvailableArrayLength(){
        $availability = new Availability($this->mockBookTblRepository(TestValues::CORRECT_BOOK_TIMES_REPOSITORY_RESPONSE));
        $result = $availability->checkAvailability(TestValues::OFFICE_ID, TestValues::SEAT_NO, BookingValues::WORKING_DAYS[1]);
        self::assertCount(2, $result);
    }


}