<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;

class Table
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct($entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getAllRecords($entity): array
    {
        return $this->entityManager->getRepository($entity)->findAll();
    }



}