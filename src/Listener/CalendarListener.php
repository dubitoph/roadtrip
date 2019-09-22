<?php

namespace App\Listener;

use CalendarBundle\Entity\Event;
use App\Repository\booking\BookingRepository;
use App\Repository\advert\VehicleRepository;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarListener
{
    private $bookingRepository;
    private $router;

    public function __construct(BookingRepository $bookingRepository, VehicleRepository $vehicleRepository, UrlGeneratorInterface $router) 
    {

        $this->bookingRepository = $bookingRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->router = $router; 

    }

    public function load(CalendarEvent $calendar): void
    {
        
        $start = $calendar->getStart()->format('Y-m-d H:i:s');
        $end = $calendar->getEnd()->format('Y-m-d H:i:s');

        $filters = $calendar->getFilters();

        $vehicle = null;
        
        if (!empty($filters))
        {
            if (array_key_exists('vehicle', $filters))
            {

                $vehiculeId = $filters['vehicle']; 

                $vehicle = $this->vehicleRepository->find($vehiculeId);
                
			}
		} 

        $bookings = $this->bookingRepository->findBetweenDates($start, $end, $vehicle);

        foreach ($bookings as $booking) 
        {

            // this create the events with your data (here booking data) to fill calendar
            $bookingEvent = new Event(
                                        $booking->getTitle(),
                                        $booking->getBeginAt(),
                                        $booking->getEndAt() // If the end date is null or not defined, a all day event is created.
                                     )
            ;

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $bookingEvent->setOptions([
                                        'backgroundColor' => 'red',
                                        'borderColor' => 'red',
                                      ]
                                     )
            ;

            $bookingEvent->addOption(
                                        'url',
                                        $this->router->generate('booking.booking.show', ['id' => $booking->getId()])
                                    )
            ;

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($bookingEvent);

        }

    }
    
}