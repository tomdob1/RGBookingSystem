<?php


namespace App\Controller;

use App\Entity\BookTbl;
use App\Form\BookingFormType;
use App\Form\OfficeFormType;
use App\Repository\BookTblRepository;
use App\Repository\OfficeTblRepository;
use App\Services\Book;
use App\Services\BookingValues;
use App\Services\Employee;
use App\Services\Office;
use App\Services\RegistrationFactory;
use App\Entity\EmployeeTbl;
use App\Entity\OfficeTbl;
use App\Form\EmployeeFormType;
use App\Services\Table;
use App\Services\Timetable;
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
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $registrationFactory = new RegistrationFactory();
            $test = $registrationFactory->createEmployee($entityManager, $employee);
            $test->addEmployeeToSystem($task);

            return $this->redirectToRoute('addEmployee');
        }

        $table = new Table($entityManager);
        $tableResults = $table->getAllRecords(EmployeeTbl::class);
        return $this->renderForm('addEmployee.html.twig', [
            'form' => $form,
            'tableResults'=> $tableResults
        ]);
    }

    /**
     * @Route("/bookingController/addOffice");
     */
    public function addOffice(Request $request): Response
    {
        $office = new OfficeTbl();
        $form = $this->createForm(OfficeFormType::class, $office);
        $entityManager = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task                = $form->getData();
            $registrationFactory = new RegistrationFactory();
            $entityManager       = $this->getDoctrine()->getManager();
            $test                = $registrationFactory->createOffice($entityManager, $office);
            $test->loopOffices( $form->get('noOfOffices')->getData(), $form->get('officeSeats')->getData());
            //TODO get rid of hard code
            return $this->redirectToRoute('addOffice');
        }
        $table = new Table($entityManager);
        $tableResults = $table->getAllRecords(OfficeTbl::class);
        return $this->renderForm('addOffice.html.twig', [
            'form'          => $form,
            'tableResults'  => $tableResults
        ]);

    }



    /**
     * @Route("/bookingController/viewBookings/")
     */
    public function viewBookings(){
        $entityManager = $this->getDoctrine()->getManager();
        $table = new Table($entityManager);
        $tableResults = $table->getAllRecords(OfficeTbl::class);
            return $this->renderForm('officeButtons.html.twig', [
            'tableResults'  => $tableResults,
            'url'           => $_SERVER['REQUEST_URI'] . 'monday'
        ]);
    }

    /**
     * @Route("/bookingController/viewBookings/{day}/{officeId}")
     */
    public function viewOfficeBookings($day, $officeId, BookTblRepository $bookTblRepository ){
        $timeTable = new TimeTable($officeId, $day, $bookTblRepository);
        $seatNumber = $this->getDoctrine()->getRepository(OfficeTbl::class)->find($officeId);
        $calendar = $timeTable->getTimeTable();
        $days     = $timeTable->getDays();
        $seatAvailability = $timeTable->seatAvailability($seatNumber->getOfficeSeats());
        return $this->renderForm('bookingTemplate.html.twig', [
            'seatNumber'        => $seatNumber->getOfficeSeats(),
            'seatAvailability'  => $seatAvailability,
            'calendar'          => $calendar,
            'url'               => $_SERVER['REQUEST_URI'],
            'baseUrl'           => $_SERVER['SERVER_NAME'],
            'days'              => $days,
            'officeId'          => $officeId
        ]);
    }

    /**
     * @Route("/bookingController/viewBookings/{day}/{officeId}/{seatId}")
     */
    public function makeBooking($day, $officeId, $seatId,  Request $request, EntityManagerInterface $entityManager):response {
        $bookTbl = new BookTbl();
        $book    = new Book($entityManager, $bookTbl);
        $availability = $book->checkAvailability($officeId, $seatId, $day);

        $form    = $this->createForm(BookingFormType::class, null, array('schedule' => $availability));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ($availability['wholeDayAvailable']) ? $data = $form->get('bookingLength')->getData() : $data = null;
            $book->addBooking( $officeId, $seatId, $day, $form->get('email')->getData(), $form->get('time')->getData(), $data);
            return $this->redirectToRoute('addOffice');
        }

        $table   = new Table($entityManager);
        $tableResults = $table->getAllRecords(OfficeTbl::class);
        return $this->renderForm('bookSeat.html.twig', [
            'form'          => $form,
            'tableResults'  => $tableResults
        ]);

    }



}
