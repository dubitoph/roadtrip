<?php

namespace App\Controller\booking;

use App\Entity\booking\Booking;
use App\Entity\advert\Vehicle;
use App\Form\booking\BookingType;
use App\Entity\communication\Mail;
use App\Form\communication\MailType;
use App\Repository\booking\BookingRepository;
use App\Repository\media\PhotoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{

    /**
     * Request a booking
     * 
     * @Route("/booking/booking/request/{id}", name="booking.booking.request")
     * 
     * @param Vehicle $vehicle
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function new(Vehicle $vehicle, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        $booking = new Booking();
        $mail = new Mail();
        $user = $this->getUser();
        $advert = $vehicle->getAdvert();      

        $booking->setVehicle($vehicle);
        $booking->setUserMail($mail);

        $beginningDateBooking = $this->container->get('session')->get('beginningDateBooking');
        $endDateBooking = $this->container->get('session')->get('endDateBooking');

        if(isset($beginningDateBooking))
        {

            $booking->setBeginAt($beginningDateBooking);

        }

        if($endDateBooking)
        {

            $booking->setEndAt($endDateBooking);

        }


        if($user != $advert->getOwner()->getUser())
        {
            
            $booking->setUser($user);
            $booking->setTitle($user->getFirstname() . ' ' . $user->getName() . ' booking');

        }

        $form = $this->createForm(BookingType::class, $booking, array('request' => true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {           

            $mail->setReceiver($advert->getOwner()->getUser())
                 ->setSubject($this->getParameter('booking_request_subject'))
                 ->setSender($user)
                 ->setBooking($booking)
                 ->setMessage($form['mail']->getData())
                 ->setBody($this->renderView(
                                                'communication/bookingRequest.html.twig', 
                                                ['mail' => $mail]
                                            )
                          )
            ;

            if ($mail->sendEmail($mailer))
            { 
                
                $manager->persist($booking);
                $manager->flush();   

                $this->addFlash('success', "Your booking request was successfully sent");

            }

            return $this->redirectToRoute('advert.show', [
                                                            'id' => $advert->getId(),
                                                            'slug' => $advert->getSlug()
                                                         ]
                                         )
            ;

        }

        return $this->render('booking/request.html.twig', [
                                                            'booking' => $booking,
                                                            'form' => $form->createView(),
                                                          ]
                            )
        ;

    }

    /**
     * @Route("/booking/booking/show/{id}", name="booking.booking.show")
     * 
     * @param Booking $booking
     * @return Response
     */
    public function show(Booking $booking): Response
    {

        return $this->render('booking/show.html.twig', ['booking' => $booking,]);

    }

    /**
     * @Route("/booking/booking/requests", name="booking.booking.requests")
     * 
     * @param BookingRepository $bookingRepository
     * @return Response
     */
    public function requests(BookingRepository $bookingRepository): Response
    {

        $ownerVehicles = array();
        
        $ownerAdverts = $this->getUser()->getOwner()->getAdverts();

        foreach ($ownerAdverts as $advert) 
        {

            $ownerVehicles[] = $advert->getVehicle();

        }

        $openedRequests = null;
        
        if(count($ownerVehicles) > 0)
        {
        
            $openedRequests = $bookingRepository->findOpenedRequests($ownerVehicles);
            $refusedRequests = $bookingRepository->findRefusedRequests($ownerVehicles);

        }
        
        return $this->render('user/bookingRequests.html.twig', [
                                                                'openedRequests' => $openedRequests,
                                                                'refusedRequests' => $refusedRequests,
                                                                'ownerVehicles' => $ownerVehicles
                                                               ]
                            )
        ;

    }

    /**
     * Update a booking with accepted or refused
     * 
     * @Route("/booking/booking/edit/{id}/{action}", name="booking.booking.edit")
     * @param Booking $booking
     * @param Request $request
     * @param ObjectManager $manager
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function edit(Booking $booking, $action, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {
        
        $mail = new Mail();
        
        if ($action == 'refuse') 
        {
            $mail->setSubject($this->getParameter('booking_request_refused_subject'));
            
        } 
        else 
        {
            $mail->setSubject($this->getParameter('booking_request_accepted_subject'));
                
        }
        

        $mail->setReceiver($booking->getUser())
             ->setSender($this->getUser())
             ->setBooking($booking)
             ->setMessage('')
             ->setBody($this->renderView(
                                            'communication/bookingRequestFollow-up.html.twig', 
                                            [
                                                'mail' => $mail,
                                                'action' => $action
                                            ]
                                            
                                        )
                      )
        ;
        
        $form = $this->createForm(MailType::class, $mail);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())   
        { 

            if ($mail->sendEmail($mailer))
            { 
                
                $booking->setOwnerMail($mail);

                if($action == 'refuse')
                {

                    $booking->setRefused(true);

                }
                else
                {

                    $booking->setAccepted(true);

                }
                
                $manager->persist($booking);
                $manager->flush();   

                $this->addFlash('success', "Your refusal was successfully sent");

            }
            else 
            {

                $this->addFlash('error', "Your refusal can't be successfully treated.");

            } 

            return $this->redirectToRoute('booking.booking.requests');

        }
     
        return $this->render('booking/edit.html.twig', [
                                                            'booking' => $booking,
                                                            'action' => $action,
                                                            'form' => $form->createView(),
                                                       ]
                            )
        ; 
    }

    /**
     * User's bookings list
     * 
     * @Route("/booking/bookings", name="booking.bookings")
     * 
     * @param BookingRepository $bookingRepository
     * @param PhotoRepository $photoRepository
     * 
     * @return Response
     */
    public function userBookings(BookingRepository $bookingRepository, PhotoRepository $photoRepository): Response
    {

        $user = $this->getUser();        
        $bookings = $bookingRepository->findBy(array('user' => $user, 'accepted' => true), array('beginAt' => 'desc'));
        $adverts = new ArrayCollection();

        foreach($bookings as $booking)
        {

            $adverts->add($booking->getVehicle()->getAdvert()); 

        }

        $mainPhotos = $photoRepository->getMainPhotos($adverts);
        
        return $this->render('user/bookings.html.twig', [
                                                            'bookings' => $bookings,
                                                            'mainPhotos' => $mainPhotos
                                                        ]
                            )
        ;

    }

    /**
     * @Route("/booking/booking/delete/{id}", name="booking.booking.delete", methods={"DELETE"})
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

        return $this->redirectToRoute('booking.booking.index');
    }

    /**
     * @Route("/owner/calendar", name="owner.calendar")
     */
    public function calendar(): Response
    {

        return $this->render('booking/calendar.html.twig');
        
    }
}
