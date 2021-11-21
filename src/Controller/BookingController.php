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
     * @Route("/");
     * Displays the home page
     */
    public function homepage()
    {
        return $this->render('homepage.html.twig', []);
    }

    /**
     * @Route("/addEmployee" );
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
            $this->addFlash('success', 'New Employee Added!');
            return $this->redirectToRoute('addEmployee');
        }
        $tableResults = $entityManager->getRepository(EmployeeTbl::class)->findAll();
        return $this->renderForm('addEmployee.html.twig', [
            'form' => $form,
            'tableResults'=> $tableResults
        ]);
    }

    /**
     * @Route("/addOffice");
     * Route to generate the add employee page. If a request is submitted to add an office, the office is created through the registration factory (abstract factory design principle)
     * The Office Route takes (n) number of offices and the no of seats.
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
            $this->addFlash('success', 'New Office Added!');
            return $this->redirectToRoute('addOffice');
        }
        $tableResults = $entityManager->getRepository(OfficeTbl::class)->findAll();
        return $this->renderForm('addOffice.html.twig', [
            'form'          => $form,
            'tableResults'  => $tableResults
        ]);
    }

    /**
     * @Route("/bookSeat")
     * 1st part of the booking process - Obtains all the offices to display buttons to navigate to the booking page for each office.
     * Check for employees as if there are no employees then the user will not be allowed to proceed.
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
     * @Route("/bookSeat/{day}/{officeId}")
     * Timetable page which displays the timetable for each seat and the option to select a seat to book.
     * This uses the timetable class to find out the schedule of each seat for that office.
     */
    public function bookSeatOffice($day, $officeId, BookTblRepository $bookTblRepository): Response
    {
        $timeTable        = new TimeTable($officeId, $day, $bookTblRepository);
        $seatNumber       = $this->getDoctrine()->getRepository(OfficeTbl::class)->find($officeId);
        $seatAvailability = $timeTable->getTimetable($seatNumber->getOfficeSeats());
        $fullyBooked      = $timeTable->fullyBooked($seatAvailability); //Used to check if any seats are fully booked.
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
     * @Route("/bookSeat/{day}/{officeId}/{seatId}")
     * Booking page - the user gets the option to submit a booking for either a whole day (if all hours of the day are available) or an hour.
     */
    public function bookSeatMakeBooking($day, $officeId, $seatId,  Request $request, EntityManagerInterface $entityManager, BookTblRepository $bookTblRepository):response {
        $book           = new Book($entityManager);
        $availability   = new Availability($bookTblRepository);
        $availableTimes = $availability->checkAvailability($officeId, $seatId, $day); //checks the availability of the specific seat
        $form           = $this->createForm(BookingFormType::class, null, array('schedule' => $availableTimes)); //passes in the availability into the form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ($availableTimes['wholeDayAvailable']) ? $data = $form->get('bookingLength')->getData() : $data = null;
            $book->addBooking($officeId, $seatId, $day, $form->get('email')->getData(), $form->get('time')->getData(), $data); //books the seat for the specific hour/day
            $this->addFlash('success', 'Booking Successful!');
            return $this->redirectToRoute('booking', array('day' => $day, 'officeId' => $officeId));
        }
        return $this->renderForm('bookSeat.html.twig', [
            'form'          => $form
        ]);
    }



}
