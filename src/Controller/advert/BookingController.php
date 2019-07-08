<?php

namespace App\Controller\advert;

use App\Entity\advert\Booking;
use App\Entity\advert\Vehicle;
use App\Form\advert\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{

    /**
     * @Route("/advert/booking/create/{id}", name="advert.booking.create")
     * 
     * @param Vehicle $vehicle
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Vehicle $vehicle, Request $request, ObjectManager $manager): Response
    {

        $booking = new Booking();       

        $booking->setVehicle($vehicle);

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $manager->persist($booking);
            $manager->flush();   

            $this->addFlash('success', "La réservation a été créée avec succès.");

//            return $this->redirectToRoute('owner.booking.index');

        }

        return $this->render('Booking/new.html.twig', [
                                                        'booking' => $booking,
                                                        'form' => $form->createView(),
                                                      ]
                            )
        ;

    }

    /**
     * @Route("/advert/booking/show/{id}", name="advert.booking.show")
     * 
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking): Response
    {

        return $this->render('booking/show.html.twig', ['booking' => $booking,]);

    }

    /**
     * @Route("/advert/booking/edit/{id}", name="advert.booking.edit")
     * @param Booking $booking
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager): Response
    {
        $form = $this->createForm(Booking1Type::class, $booking);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())   
        {       

            $manager->flush();

            $this->addFlash('success', "La réservation a été modifiée avec succès."); 

            return $this->redirectToRoute('advert.booking.index', ['id' => $booking->getId(),]);

        }
     
        return $this->render('booking/edit.html.twig', [
                                                            'booking' => $booking,
                                                            'form' => $form->createView(),
                                                       ]
                            )
        ; 
    }

    /**
     * @Route("/advert/booking/delete/{id}", name="advert.booking.delete", methods={"DELETE"})
     * @param Booking $booking
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Booking $booking, Request $request, ObjectManager $manager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) 
        {

            $manager->remove($booking);
            $manager->flush();

            $this->addFlash('success', "La réservation a été supprimée avec succès.");

        }

        return $this->redirectToRoute('backend.booking.index');
    }

    /**
     * @Route("/owner/calendar", name="owner.calendar")
     */
    public function calendar(): Response
    {

        return $this->render('booking/calendar.html.twig');
        
    }
}
