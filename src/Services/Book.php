<?php


namespace App\Services;
use App\Entity\BookTbl;
use App\Entity\EmployeeTbl;
use App\Interfaces\BookInterface;
use Doctrine\ORM\EntityManagerInterface;

class Book implements BookInterface
{
    //class used to create a booking
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @param $officeId
     * @param $seatId
     * @param $day
     * @param $employeeEmail
     * @param null $time
     * @param int $data
     * Checks to see whether a whole day or an hour booking was selected
     */
    public function addBooking($officeId, $seatId, $day, $employeeEmail, $time = null, $data = 0){
        $employee = $this->entityManager->getRepository(EmployeeTbl::class)->find($employeeEmail);
        $employeeId = $employee->getId();

            if ($data == 1) {
                $this->createWholeDayBooking($officeId, $seatId, $day, $employeeId);
            }
            else if ($data == 0){
                $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time);
            }
    }

    /**
     * @param $officeId
     * @param $seatId
     * @param $day
     * @param $employeeId
     * @param $time
     * creates a one hour booking within the database
     */
    private function createOneHourBooking($officeId, $seatId, $day, $employeeId, $time) {
        $bookTbl = new BookTbl();
        $bookTbl->setOfficeId($officeId);
        $bookTbl->setSeatNo($seatId);
        $bookTbl->setBookingDate($day);
        $bookTbl->setBookingTime($time);
        $bookTbl->setEmployeeId($employeeId);
        $this->entityManager->persist($bookTbl);
        $this->entityManager->flush();
    }

    /**
     * @param $officeId
     * @param $seatId
     * @param $day
     * @param $employeeId
     * loops through the schedule of the day and creates a booking
     */
    private function createWholeDayBooking($officeId, $seatId, $day, $employeeId)
    {
        foreach(BookingValues::CALENDAR as $time){
            $this->createOneHourBooking($officeId, $seatId, $day, $employeeId, $time);
        }
    }




}