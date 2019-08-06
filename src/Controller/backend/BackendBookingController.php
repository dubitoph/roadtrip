<?php

namespace App\Controller\backend;

use App\Repository\booking\BookingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendBookingController extends AbstractController
{
    
    /**
     * @Route("/backend/bookings", name="backend.booking.index")
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    public function index(BookingRepository $bookingRepository): Response
    {
     
        $bookings = $bookingRepository->findAll();
    
        return $this->render('backend/booking/index.html.twig', compact('bookings'));

    }

}
