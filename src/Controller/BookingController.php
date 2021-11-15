<?php


namespace App\Controller;

use App\Classes\Employee;
use App\Classes\RegistrationFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController {
    /**
     * @Route("/bookingController");
     */
    public function homepage()
    {
        return $this->render('homepage.html', []);
    }

    /**
     * @Route("/bookingController/addEmployee" );
     */
    public function getAddEmployeeForm()
    {
        return $this->render('addEmployee.html', []);
    }

    /**
     * @Route("/bookingController/addEmployee" methods={"POST"});
     */
    public function addEmployee(Request $request){
        $firstName = $request->query->get('firstName');
        $lastName = $request->query->get('lastName');
        $email = $request->query->get('email');
        $payrollNo = $request->query->get('payrollNo');
        $registrationFactory = new RegistrationFactory();
        $test = $registrationFactory->createEmployee($firstName, $lastName, $email, $payrollNo);
    }

    /**
     * @Route("/bookingController/addOffice");
     */
    public function addOffice()
    {
        return $this->render('addOffice.html', []);
    }

    /**
     * @Route("/bookingController/
     */

}
