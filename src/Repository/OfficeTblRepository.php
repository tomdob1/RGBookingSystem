<?php

namespace App\Repository;

use App\Entity\OfficeTbl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfficeTbl|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfficeTbl|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfficeTbl[]    findAll()
 * @method OfficeTbl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfficeTblRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfficeTbl::class);
    }

}
