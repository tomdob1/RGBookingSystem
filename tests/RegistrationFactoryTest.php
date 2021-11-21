<?php


namespace App\Tests;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Services\Employee;
use App\Services\Office;
use App\Services\RegistrationFactory;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationFactoryTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|EntityManagerInterface
     * Returns a mocked entity manager
     */
    public function mockEntityManager(): \PHPUnit\Framework\MockObject\MockObject|EntityManagerInterface
    {
        return $this->getMockBuilder(EntityManagerInterface::class)->getMock();
    }

    /**
     * Tests to see if the CreateEmployee function returns an object
     */
    public function testCreateEmployeeIsObject(){
        $employeeTbl = new EmployeeTbl();
        $registrationFactory = new RegistrationFactory($this->mockEntityManager());
        self::assertIsObject($registrationFactory->createEmployee($employeeTbl), 'testCreateEmployeeIsObject does not return an object');
    }

    /**
     * Tests to see if the createOffice function returns an object
     */
    public function testCreateOfficeIsObject(){
        $officeTbl = new OfficeTbl();
        $registrationFactory = new RegistrationFactory($this->mockEntityManager());
        self::assertIsObject($registrationFactory->createOffice($officeTbl), 'testCreateOfficeIsObject does not return an object');
    }

    /**
     * Tests to see if the createEmployee function returns an employee object
     */
    public function testCreateEmployeeObject(){
        $employeeTbl = new EmployeeTbl();
        $registrationFactory = new RegistrationFactory($this->mockEntityManager());
        $employee = new Employee($this->mockEntityManager(), $employeeTbl);
        self::assertEquals($employee, $registrationFactory->createEmployee($employeeTbl), 'testCreateEmployeeObject does not match an Employee object');
    }

    /**
     * Tests to see if the createOffice function returns an office object
     */
    public function testCreateOfficeObject(){
        $officeTbl = new OfficeTbl();
        $registrationFactory = new RegistrationFactory($this->mockEntityManager());
        $office    = new Office($this->mockEntityManager(), $officeTbl);
        self::assertEquals($office, $registrationFactory->createOffice($officeTbl), 'testCreateOfficeObject does not match an Office object');
    }
}