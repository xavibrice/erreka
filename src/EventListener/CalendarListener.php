<?php

namespace App\EventListener;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\Security\Core\Security;

class CalendarListener
{
    private $bookingRepository;
    private $router;
    private $security;

    public function __construct(
        BookingRepository $bookingRepository,
        UrlGeneratorInterface $router,
        Security $security
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->router = $router;
        $this->security = $security;
    }

    public function load(CalendarEvent $calendar): void
    {
        $agency = $this->security->getUser()->getAgency()->getName();
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $bookings = $this->bookingRepository
            ->createQueryBuilder('booking')
            ->innerJoin('booking.commercial', 'commercial')
            ->innerJoin('commercial.agency', 'agency')
            ->andWhere('booking.beginAt BETWEEN :start and :end')
            ->andWhere('agency.name = :agency')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->setParameter('agency', $agency)
            ->getQuery()
            ->getResult()
        ;

        foreach ($bookings as $booking) {
            // this create the events with your data (here booking data) to fill calendar
            $bookingEvent = new Event(
                $booking->getCommercial()->getFullname() . ' - ' .$booking->getTitleBooking()->getName(),
                $booking->getBeginAt(),
                $booking->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $bookingEvent->setOptions([
                'backgroundColor' => $booking->getCommercial()->getBackgroundColor(),
//                'borderColor' => $booking->getColor(),
                'textColor' => 'white',
                'idBooking' => $booking->getId(),
                'description' => $booking->getDescription(),
                'commercial' => $booking->getCommercial()->getFullname(),
                'location' => $booking->getLocationBooking()->getName(),
            ]);
//            $bookingEvent->addOption(
//                'url',
//                $this->router->generate('booking_show', [
//                    'id' => $booking->getId(),
//                ])
//            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($bookingEvent);
        }
    }
}