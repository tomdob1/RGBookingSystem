<?php


namespace App\Controller;

use App\Form\BookingFormType;
use App\Form\OfficeFormType;
use App\Repository\BookTblRepository;
use App\Services\Availability;
use App\Services\Book;
use App\Services\BookingValues;
use App\Services\RegistrationFactory;
use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Form\EmployeeFormType;
use App\Services\Timetable;
use Doctrine\ORM\EntityManagerInterface;
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
        return $this->render('homepage.html.twig', []);
    }

    /**
     * @Route("/bookingController/addEmployee" );
     * Route to generate the add employee page. If a request is submitted to add an employee, the employee is created through the registration factory (abstract factory design principle)
     */
    public function addEmployee(Request $request, EntityManagerInterface $entityManager):Response
    {
        $employeeTbl = new EmployeeTbl();
        $form = $this->createForm(EmployeeFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registrationFactory = new RegistrationFactory($entityManager);
            $employee = $registrationFactory->createEmployee($employeeTbl);
            $employee->addEmployeeToSystem($form->getData());
            return $this->redirectToRoute('addEmployee');
        }

        $tableResults = $entityManager->getRepository(EmployeeTbl::class)->findAll();
        return $this->renderForm('addEmployee.html.twig', [
            'form' => $form,
            'tableResults'=> $tableResults
        ]);
    }

    /**
     * @Route("/bookingController/addOffice");
     */
    public function addOffice(Request $request, EntityManagerInterface $entityManager): Response
    {
        $office = new OfficeTbl();
        $form = $this->createForm(OfficeFormType::class, $office);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registrationFactory = new RegistrationFactory($entityManager);
            $office              = $registrationFactory->createOffice($office);
            $office->addOffices($form->get('noOfOffices')->getData(), $form->get('officeSeats')->getData());
            return $this->redirectToRoute('addOffice');
        }
        $tableResults = $entityManager->getRepository(OfficeTbl::class)->findAll();
        return $this->renderForm('addOffice.html.twig', [
            'form'          => $form,
            'tableResults'  => $tableResults
        ]);
    }

    /**
     * @Route("/bookingController/bookSeat")
     */
    public function bookSeat(EntityManagerInterface $entityManager): Response
    {
        $employees = $entityManager->getRepository(EmployeeTbl::class)->findAll();
        $tableResults = $entityManager->getRepository(OfficeTbl::class)->findAll();
            return $this->renderForm('officeButtons.html.twig', [
            'tableResults'  => $tableResults,
            'url'           => $_SERVER['REQUEST_URI'] . '/monday',
            'employees'     => $employees
        ]);
    }

    /**
     * @Route("/bookingController/bookSeat/{day}/{officeId}")
     */
    public function bookSeatOffice($day, $officeId, BookTblRepository $bookTblRepository): Response
    {
        $timeTable        = new TimeTable($officeId, $day, $bookTblRepository);
        $seatNumber       = $this->getDoctrine()->getRepository(OfficeTbl::class)->find($officeId);
        $seatAvailability = $timeTable->getTimetable($seatNumber->getOfficeSeats());
        $fullyBooked      = $timeTable->fullyBooked($seatAvailability);
        return $this->renderForm('bookingTemplate.html.twig', [
            'seatNumber'        => $seatNumber->getOfficeSeats(),
            'seatAvailability'  => $seatAvailability,
            'calendar'          => BookingValues::CALENDAR,
            'url'               => $_SERVER['REQUEST_URI'],
            'fullyBooked'       => $fullyBooked,
            'days'              => BookingValues::WORKING_DAYS,
            'day'               => $day,
            'officeId'          => $officeId
        ]);
    }

    /**
     * @Route("/bookingController/bookSeat/{day}/{officeId}/{seatId}")
     */
    public function bookSeatMakeBooking($day, $officeId, $seatId,  Request $request, EntityManagerInterface $entityManager, BookTblRepository $bookTblRepository):response {
        $book           = new Book($entityManager);
        $availability   = new Availability($bookTblRepository);
        $availableTimes = $availability->checkAvailability($officeId, $seatId, $day);
        $form           = $this->createForm(BookingFormType::class, null, array('schedule' => $availableTimes));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ($availableTimes['wholeDayAvailable']) ? $data = $form->get('bookingLength')->getData() : $data = null;
            $book->addBooking($officeId, $seatId, $day, $form->get('email')->getData(), $form->get('time')->getData(), $data);
            return $this->redirectToRoute('booking', array('day' => $day, 'officeId' => $officeId));
        }
        return $this->renderForm('bookSeat.html.twig', [
            'form'          => $form
        ]);
    }



}
