<?php

namespace App\Controller\rating;

use App\Entity\rating\Rating;
use App\Entity\booking\Booking;
use App\Form\rating\RatingType;
use App\Entity\communication\Mail;
use App\Entity\rating\ResponseToRating;
use App\Form\rating\RatingResponseType;
use App\Repository\user\UserRepository;
use App\Repository\media\PhotoRepository;
use App\Repository\rating\RatingRepository;
use App\Repository\booking\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RatingController extends AbstractController
{ 

    /**
     * User's ratings dashboard
     * 
     * @Route("/rating/dashboard", name="rating.dashboard")
     * 
     * @param BookingRepository $bookingRepository
     * @param PhotoRepository $photoRepository
     * @param RatingRepository $ratingRepository
     * 
     * @return Response
     */
    public function dashbord(BookingRepository $bookingRepository, PhotoRepository $photoRepository, RatingRepository $ratingRepository): Response
    {
     
        $user = $this->getUser();
        $owner = $user->getOwner();

        $bookingsWithoutRating = $bookingRepository->findBookingsWithoutRating($user);

        $toRateTenantBookings = new ArrayCollection();
        $toRateOwnerBookings = new ArrayCollection();        
        $adverts = new ArrayCollection(); 

        foreach($bookingsWithoutRating as $booking)
        {
            
            if($booking->getUser() == $user)
            {

                $toRateTenantBookings->add($booking);                

            }
            else 
            {

                $toRateOwnerBookings->add($booking);

            }

            $adverts->add($booking->getVehicle()->getAdvert());

        }
        
        $mainPhotos = array();

        if (count($adverts) > 0) 
        {
        
            $mainPhotos = $photoRepository->getMainPhotos($adverts);

        }

        $receivedUserRatings = $ratingRepository->findReceivedUserRatings($user);
        
        $receivedOwnerRatings = array();
        $givenUserRatings = array();

        if ($owner) 
        {

            $receivedOwnerRatings = $ratingRepository->findReceivedOwnerRatings($owner);
            $givenUserRatings = $ratingRepository->findGivenUserRatings($owner);

        }

        $givenOwnerRatings = $ratingRepository->findGivenOwnerRatings($user);

        $approvedGivenOwnerRatings = new ArrayCollection();
        $givenOwnerRatingsToApprove = new ArrayCollection();

        foreach($givenOwnerRatings as $rating)
        {

            if ($rating->getApprovedRating()) 
            {

                $approvedGivenOwnerRatings->add($rating);

            }
            else 
            {

                $givenOwnerRatingsToApprove->add($rating);

            }            

        }

        $givenTenantRatings = $ratingRepository->findGivenTenantRatings($user);

        $approvedGivenTenantRatings = new ArrayCollection();
        $givenTenantRatingsToApprove = new ArrayCollection();

        foreach($givenTenantRatings as $rating)
        {

            if ($rating->getApprovedRating()) 
            {

                $approvedGivenTenantRatings->add($rating);

            }
            else 
            {

                $givenTenantRatingsToApprove->add($rating);

            }            

        }
    
        return $this->render('rating/ratingsDashboard.html.twig',array(
                                                                        'toRateTenantBookings' => $toRateTenantBookings,
                                                                        'toRateOwnerBookings' => $toRateOwnerBookings,
                                                                        'receivedUserRatings' => $receivedUserRatings,
                                                                        'receivedOwnerRatings' => $receivedOwnerRatings,
                                                                        'givenUserRatings' => $givenUserRatings,
                                                                        'approvedGivenOwnerRatings' => $approvedGivenOwnerRatings,
                                                                        'givenOwnerRatingsToApprove' => $givenOwnerRatingsToApprove,
                                                                        'approvedGivenTenantRatings' => $approvedGivenTenantRatings,
                                                                        'givenTenantRatingsToApprove' => $givenTenantRatingsToApprove,
                                                                        'mainPhotos' => $mainPhotos,
                                                                        'bodyId' =>  'ratingsDashboard'
                                                                     )
                            )
        ;  
        
    }

    /**
     * Rating creation
     * 
     * @Route("/rating/create/{id}", name="rating.create")
     * 
     * @param Booking $booking
     * @param UserRepository $userRepository
     * @param Request $request
     * @param ObjectManager $manager
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function new(Booking $booking, UserRepository $userRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        $user = $this->getUser();
        
        $rating = new Rating;

        $rating->setBooking($booking);
        $rating->setUser($user);

        if ($user == $booking->getUser()) 
        {

            $rating->setAdvert($booking->getVehicle()->getAdvert());

        } 
        else 
        {

            $rating->setTenant($booking->getUser());

        }
            

        $form = $this->createForm(RatingType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {            

            $manager->persist($rating);
            $manager->flush();    

            $this->addFlash('success', "The evaluation was successfully created and is awaiting approval by an administrator for publication."); 

            $message = "A new rating is pending approval. Please manage it in the <a href=\"" . $this->generateUrl('backend.rating.toApprove', array(), UrlGeneratorInterface::ABSOLUTE_URL) . "\">dashboard</a>.";
                
            $this->sendPendingApprovalRatingMail($mailer, $userRepository, $message);
                
            return $this->redirectToRoute('rating.dashboard');

        }
        
        return $this->render('rating/new.html.twig', [
                                                        'rating' => $rating,
                                                        'bodyId' =>  'ratingCreation',
                                                        'form' => $form->createView(),
                                                     ]
                            )
        ; 

    }

    /**
     * @Route("/rating/show/{id}", name="rating.show")
     * @param Rating $rating
     * @return Response
     */
    public function show(Rating $rating, Request $request, ObjectManager $manager): Response
    {

        $responseCompleted = $rating->getResponse();

        if (! $responseCompleted) 
        {
        
            $form = $this->createForm(RatingResponseType::class, $rating);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {           

                $manager->persist($rating);
                $manager->flush();

                $this->addFlash('success', "La réponse à l'évaluation a été enregistrée avec succès. Elle ne sera visible dans l'annonce qu'après approbation d'un administrateur"); 
                
            }
        
            return $this->render('rating/show.html.twig', array(
                                                                    'rating' => $rating,
                                                                    'bodyId' =>  'ratingsShow',
                                                                    'form' => $form->createView()
                                                               )
                                )
            ; 

        } 
        else 
        {
        
            return $this->render('rating/show.html.twig', array(
                                                                    'rating' => $rating,
                                                                    'bodyId' =>  'ratingsShow'
                                                               )
                                )
            ;

        } 
        
    }

    /**
     * @Route("/rating/edit/{id}", name="rating.edit")
     * @param Rating $rating
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Rating $rating, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(RatingType::class, $rating);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "L'évaluation a été modifiée avec succès.");                   

            return $this->redirectToRoute('advert.rating.index');
        }
     
        return $this->render('rating/edit.html.twig', array(
                                                                'rating' => $rating,
                                                                'bodyId' =>  'ratingsEdition',
                                                                'form' => $form->createView()
                                                           )
                            )
        ;  
        
    }

    /**
     * Answer to a rating
     * 
     * @Route("/rating/create/response/{id}", name="rating.create.response")
     * 
     * @param Rating $rating
     * @param UserRepository $userRepository
     * @param Request $request
     * @param ObjectManager $manager
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function response(Rating $rating, UserRepository $userRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        $response = trim($request->request->get('response_' . $rating->getId()));
        
        if($response)
        {
        
            $responseToRating = new ResponseToRating();

            $responseToRating->setUser($this->getUser())
                             ->setRating($rating)
                             ->setResponse($response);

            $rating->setResponseToRating($responseToRating);

            $manager->persist($rating);
            $manager->flush();

            $this->addFlash('success', "Your response was successfully created and it's pending to administrator approval.");

            $message = "A new response to rating is pending approval. Please manage it in the <a href=\"" . $this->generateUrl('backend.rating.toApprove', array(), UrlGeneratorInterface::ABSOLUTE_URL) . "\">dashboard</a>.";
            
            $this->sendPendingApprovalRatingMail($mailer, $userRepository, $message);
    
        }
        else 
        {

            $this->addFlash('error', "You caun't send an empty response");

        }

        return $this->redirectToRoute('rating.dashboard');

    }

    /**
     * 
     *
     * @param \Swift_Mailer $mailer
     * @param UserRepository $userRepository
     * @param String $message
     * 
     * @return Mail
     */
    private function sendPendingApprovalRatingMail($mailer, $userRepository, $message)
    { 

        $mail = new Mail;  

        $sender = $userRepository->findOneBy(array('username' => 'administrator'));
        $receiver = $userRepository->findOneBy(array('username' => 'ratingsAdministrator')); 

        $mail->setSender($sender)
             ->setReceiver($receiver)
             ->setSubject($this->getParameter('rating_pending_approval_subject'))
             ->setMessage($message)
             ->setBody($this->renderView(
                                            'communication\administrationEmail.html.twig', 
                                            ['mail' => $mail]
                                        )
                      )
        ;

        if($mail->sendEmail($mailer))
        {

            return $mail;

        }
        else
        {

            return null;

        }

    }

}