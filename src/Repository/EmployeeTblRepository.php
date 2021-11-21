<?php

namespace App\Repository;

use App\Entity\EmployeeTbl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EmployeeTbl|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeTbl|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeTbl[]    findAll()
 * @method EmployeeTbl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeTblRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeTbl::class);
    }

    public function findEmployees()
    {
        return $this->createQueryBuilder('e')
            ->select('e.email')
            ->getQuery()
            ->getResult()
        ;
    }
}
