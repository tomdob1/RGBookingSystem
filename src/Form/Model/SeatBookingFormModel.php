<?php


namespace App\Form\Model;


use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use ContainerTvx5Txc\getEmployeeControllerService;
use Doctrine\ORM\EntityManagerInterface;

class SeatBookingFormModel
{
 public $email;
 public $time;

 public function construct(EntityManagerInterface $entityManager){
     $employees = $entityManager->getRepository(EmployeeTbl::class);
     $this->email = $employees->findEmployees();
 }



 public function getOffices(){

 }

}