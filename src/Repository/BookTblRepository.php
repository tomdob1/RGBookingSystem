<?php

namespace App\Repository;

use App\Entity\BookTbl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookTbl|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookTbl|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookTbl[]    findAll()
 * @method BookTbl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookTblRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookTbl::class);
    }


    /**
     * @param $officeId
     * @param $day
     * @return int|mixed|string
     * returns the list of seats which have a booking for a specific office and day
     */
    public function findTakenSeats($officeId, $day){
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->distinct(true)
            ->select('b.seatNo')
            ->from(BookTbl::class, 'b')
            ->where('b.officeId = :officeId AND b.bookingDate = :bookingDate')
            ->orderBy('b.seatNo')
            ->setParameters(array(
                'officeId'  => $officeId,
                'bookingDate' => $day));
        $query = $qb->getQuery();
        return $query->getResult();
    }

    /**
     * @param $seatId
     * @param $officeId
     * @param $day
     * @return int|mixed|string
     * returns a list of booking times for a specific seat and office on a particular day
     */
    public function findSeatBookingTimes($seatId, $officeId, $day){
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('b.bookingTime')
            ->from(BookTbl::class, 'b')
            ->where('b.officeId = :officeId AND b.bookingDate = :bookingDate AND b.seatNo = :seatNo')
            ->setParameters(array(
                'officeId'  => $officeId,
                'bookingDate' => $day,
                'seatNo'      => $seatId));
        $query = $qb->getQuery();
        return $query->getResult();
    }


}
