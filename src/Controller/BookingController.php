<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/booking")
 */
class BookingController extends AbstractController
{

    /**
     * @Route("/calendar", name="booking_calendar", methods={"GET", "POST"})
     */
    public function calendar(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking, [
            'agency' => $this->getUser()->getAgency()->getName()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            $this->addFlash('success', 'Booking creado correctamente');

            return $this->redirectToRoute('booking_calendar');
        }

        return $this->render('admin/booking/calendar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('admin/booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('admin/booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }


    /**
     * @Route("/{id}/edit", options={"expose"=true}, name="booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {

        $start = new \DateTime($request->request->get('beginAt'));
        $end = new \DateTime($request->request->get('endAt'));

        $booking->setBeginAt($start);
        $booking->setEndAt($end);
        $this->getDoctrine()->getManager()->flush();

//        $form = $this->createForm(BookingType::class, $booking);
//        $form->handleRequest($request);


//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();

//            return new JsonResponse(true);
//            return $this->redirectToRoute('booking_index', [
//                'id' => $booking->getId(),
//            ]);
//        }

//        return $this->render('admin/booking/edit.html.twig', [
//            'booking' => $booking,
//            'form' => $form->createView(),
//        ]);
        return new JsonResponse(true);
    }

    /**
     * @Route("/editar/{id}", options={"expose"=true}, name="booking_editar", methods={"GET","POST"})
     */
    public function editBooking(Request $request, Booking $booking): Response
    {

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_calendar');
        }

        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", options={"expose"=true}, name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking): Response
    {
//        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
//        }

        return new JsonResponse(true);
//        return $this->redirect($this->generateUrl('booking_index'));
    }
}
