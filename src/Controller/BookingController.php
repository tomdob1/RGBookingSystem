<?php


namespace App\Controller;

use App\Form\OfficeFormType;
use App\Services\Employee;
use App\Services\RegistrationFactory;
use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Form\EmployeeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Config\Doctrine\Orm\EntityManagerConfig;

class BookingController extends AbstractController {
    /**
     * @Route("/bookingController");
     */
    public function homepage()
    {
        return $this->render('homepage.html.twig', []);
    }

    /**
     * @Route("/bookingController/addEmployee" );
     */
    public function addEmployee(Request $request):Response
    {
        $employee = new EmployeeTbl();
        $form = $this->createForm(EmployeeFormType::class, $employee);
//        return $this->render('addEmployee.html.twig', []);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $registrationFactory = new RegistrationFactory();
            $entityManager = $this->getDoctrine()->getManager();
            $test = $registrationFactory->createEmployee($entityManager, $employee);
            $test->addEmployeeToSystem($task);

            return $this->redirectToRoute('addEmployee');
        }

        return $this->renderForm('addEmployee.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/bookingController/addOffice");
     */
    public function addOffice(Request $request): Response
    {
        $office = new OfficeTbl();
        $form = $this->createForm(OfficeFormType::class, $office);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task                = $form->getData();
            $registrationFactory = new RegistrationFactory();
            $entityManager       = $this->getDoctrine()->getManager();
            $test                = $registrationFactory->createOffice($entityManager, $office);
            $test->loopOffices( $form->get('noOfOffices')->getData(), $form->get('officeSeats')->getData());
            //TODO get rid of hard code
            return $this->redirectToRoute('/bookingController/addOffice');
        }

        return $this->renderForm('addOffice.html.twig', [
            'form' => $form,
        ]);

    }



    /**
     * @Route("/bookingController/
     */

}
