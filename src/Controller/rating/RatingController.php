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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RatingController extends AbstractController
{
    
    /**
     * @Route("/ratings", name="advert.rating.index")
     * @param RatingRepository $ratingRepository
     * @return Response
     */
    public function index(RatingRepository $ratingnRepository): Response
    {
     
        $ratings = $ratingnRepository->findAll();
    
        return $this->render('rating/index.html.twig', array(
                                                                'ratings' => $ratings,
                                                                'bodyId' =>  'ratingsIndex'
                                                            )
                            )
        ;  
        
    } 

    /**
     * @Route("/rating/dashbord", name="rating.dashbord")
     * @param RatingRepository $ratingRepository
     * @return Response
     */
    public function dashbord(BookingRepository $bookingRepository, PhotoRepository $photoRepository, RatingRepository $ratingRepository): Response
    {
     
        $user = $this->getUser();
        $owner = $user->getOwner();
        
        $bookingsWithoutRating = $bookingRepository->findBookingsWithoutRating($user);
        
        $adverts = array();

        if (count($bookingsWithoutRating) > 0) 
        {
        
            foreach ($bookingsWithoutRating as $booking) 
            {

                $adverts[] = $booking->getVehicle()->getAdvert();

            }

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
    
        return $this->render('rating/ratingsDashbord.html.twig',array(
                                                                        'bookingsWithoutRating' => $bookingsWithoutRating,
                                                                        'receivedUserRatings' => $receivedUserRatings,
                                                                        'receivedOwnerRatings' => $receivedOwnerRatings,
                                                                        'givenUserRatings' => $givenUserRatings,
                                                                        'givenOwnerRatings' => $givenOwnerRatings,
                                                                        'mainPhotos' => $mainPhotos,
                                                                        'bodyId' =>  'ratingsDashbooard'
                                                                     )
                            )
        ;  
        
    }

    /**
     * @Route("/rating/create/{id}", name="rating.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Booking $booking, UserRepository $userRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        $user = $this->getUser();
        
        if (! $user) 
        {

            $this->addFlash("error", "Vous devez être connecté pour pouvoir laissez une évaluation");

            return $this->redirectToRoute('security.login');

        }
        else
        {
        
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
                
                return $this->redirectToRoute('rating.dashbord');

            }
        
            return $this->render('rating/new.html.twig', [
                                                            'rating' => $rating,
                                                            'bodyId' =>  'ratingsCreation',
                                                            'form' => $form->createView(),
                                                         ]
                                )
            ;  
            
        }

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
     * @Route("/rating/create/response/{id}", name="rating.create.response")
     * @param Request $request
     * @param ObjectManager $manager
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

        return $this->redirectToRoute('rating.dashbord');

    }

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