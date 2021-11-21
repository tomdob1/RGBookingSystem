<?php


namespace App\Tests;


use App\Repository\BookTblRepository;
use App\Repository\EmployeeTblRepository;
use App\Services\Book;
use Doctrine\ORM\EntityManagerInterface;

class BookTest extends \PHPUnit\Framework\TestCase
{
    //TODO write unit test if you have time

    public $test;

    public function mockEntityManager(): \PHPUnit\Framework\MockObject\MockObject|EntityManagerInterface
    {
         return $this->getMockBuilder(EntityManagerInterface::class)->getMock();
    }

    public function testSuccessfulCheckAvailableKeys(){
        $book = new Book($this->mockEntityManager());
         }

}