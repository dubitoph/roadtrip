<?php

namespace App\Controller\calendar;

use App\Entity\advert\Vehicle;
use App\Entity\calendar\Month;
use App\Repository\booking\BookingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{
    
    /**
     * @Route("/calendar/show/{vehicle}/{intMonth}/{intYear}/{toInclude}", name="calendar.show")
     * 
     * @return Response
     */
    public function show(Vehicle $vehicle, ?int $intMonth = null, ?int $intYear = null, ?bool $toInclude = null, BookingRepository $bookingRepository): Response
    {
     
        // Month to show
        try 
        {

            $month = new Month($intMonth, $intYear);

        } 
        catch (\Exception $e) 
        {

            $month = new Month();

        }
        
        $firstCalendarDay = $month->getStartingDate();
        $firstCalendarDay = $firstCalendarDay->format('N') === '1' ? $firstCalendarDay : $month->getStartingDate()->modify('last monday');

        $endCalendarDay = (clone $firstCalendarDay)->modify('+' . (6 + (7 * ($month->getWeeks() - 1))) . ' days');

        $firstCalendarDay->setTime('00', '00', '00');
        $endCalendarDay->setTime('23', '59', '59');

        // Get the bookings for the month to show
        $bookings = $bookingRepository->findBetweenDates($firstCalendarDay, $endCalendarDay, $vehicle);

        $AMDays = array();
        $PMDays = array();
        $halfDays = new \DatePeriod($firstCalendarDay, new \DateInterval('PT12H'), $endCalendarDay);
        
        foreach($bookings as $booking)
        {

            foreach ($halfDays as $halfDay)
            {
               
                if($booking->getBeginAt() <= $halfDay && $booking->getEndAt() >= $halfDay)
                {

                    if($halfDay->format('H:i:s') == '00:00:00')
                    {

                        $AMDays[$halfDay->format('Y-m-d')] = $booking;

                    }
                    else
                    {

                        $PMDays[$halfDay->format('Y-m-d')] = $booking;

                    }

                }

            }


        }

        if(! $toInclude)
        {

            $template = 'calendar/show.html.twig';

        }
        else
        {

            $template = 'calendar/_calendar.html.twig';

        }

        return $this->render(
                                $template, 
                                [
                                    'month' => $month,
                                    'firstCalendarDay' => $firstCalendarDay,
                                    'vehicleId' => $vehicle->getId(),
                                    'AMDays' => $AMDays,
                                    'PMDays' => $PMDays
                                ]
                            )
        ;        

    }

}