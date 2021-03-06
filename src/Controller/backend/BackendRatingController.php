<?php

namespace App\Controller\backend;

use App\Entity\rating\Rating;
use App\Entity\communication\Mail;
use App\Entity\rating\ResponseToRating;
use App\Repository\user\UserRepository;
use App\Repository\rating\RatingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\rating\ResponseToRatingRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendRatingController extends AbstractController
{
    
    /**
     * List of ratings and response to these to approuve
     * 
     * @Route("/backend/rating/toAppove", name="backend.rating.toApprove")
     * 
     * @param RatingRepository $ratingRepository
     * @param ResponseToRatingRepository $responseToRatingRepository
     * 
     * @return Response
     */
    public function ratingsToApprove(RatingRepository $ratingRepository, ResponseToRatingRepository $responseToRatingRepository): Response
    {
     
        $ratings = $ratingRepository->findBy(
                                                array('approvedRating' => null),
                                                array('createdAt' => 'asc')
                                            )
        ;
     
        $responses = $responseToRatingRepository->findBy(
                                                            array('approved' => null),
                                                            array('createdAt' => 'asc')
                                                        )
        ;
    
        return $this->render('backend/rating/ratingsToApprove.html.twig', [
                                                                            'ratings' => $ratings,
                                                                            'responses' => $responses,
                                                                            'bodyId' => 'ratingsToApprove'
                                                                          ]
                            )
        ;  
        
    }

    /**
     * Rating removing
     * 
     * @Route("/backend/rating/delete/{id}", name="backend.rating.delete", methods = "DELETE")
     * 
     * @param Rating $rating
     * @param UserRepository $userRepository
     * @param Request $request
     * @param ObjectManager $manager
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function delete(Rating $rating, UserRepository $userRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        if ($this->isCsrfTokenValid('delete'. $rating->getId(), $request->get('_token'))) 
        {

            $manager->remove($rating);

            $mail = new Mail();
            
            $sender = $userRepository->findOneBy(array('username'=> 'administrator'));

            $message = "Your comment in the rating about your booking from " . $rating->getBooking()->getFormattedBeginAt() . " to " . $rating->getBooking()->getFormattedEndAt() . 
                       " for the advert \"" . $rating->getBooking()->getVehicle()->getAdvert()->getTitle() . "\" didn't respect the Raodtripr's rules.
                       So, it's removed.<br>
                       However, you can leave a new response respecting the Roadtripr rules using your <a href=\"". 
                       $this->generateUrl('rating.dashboard', array(), UrlGeneratorInterface::ABSOLUTE_URL) .
                       "\">ratings dashboard</a>";
    
            $mail->setSender($sender)
                 ->setReceiver($rating->getUser())
                 ->setSubject($this->getParameter('removed_rating_subject'))
                 ->setMessage($message)
                 ->setBody($this->renderView(
                                                'communication\toUserEmail.html.twig', 
                                                ['mail' => $mail]
                                            )
                          )
            ;
    
            if($mail->sendEmail($mailer))
            {
    
                $manager->persist($mail);
    
            }


            $manager->flush();

            $this->addFlash('success', "The rating was successfully removed"); 

        } 
            
         return $this->redirectToRoute('backend.rating.toApprove');
        
    }

    /**
     * Approve a rating
     * 
     * @Route("/backend/rating/approve/{id}", name="backend.rating.approve")
     * 
     * @param Rating $rating
     * @param UserRepository $userRepository
     * @param Request $request
     * @param ObjectManager $managert
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function approve(Rating $rating, UserRepository $userRepository, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        $rating->setApprovedRating(true);
        
        $manager->persist($rating);
        $manager->flush();

        $this->addFlash('success', "The rating was successfully approved.");
        
        $sender = $userRepository->findOneBy(array('username'=> 'administrator'));
        $advert = $rating->getBooking()->getVehicle()->getAdvert();
        $subject = $this->getParameter('approved_rating_subject');        

        // Send an email to the user who created the rating       
        $mail = new Mail();
        $message = "Your rating about your booking from " . $rating->getBooking()->getFormattedBeginAt() . " to " . $rating->getBooking()->getFormattedEndAt() . 
                   " for the advert \"" . $rating->getBooking()->getVehicle()->getAdvert()->getTitle() . "\" was approved.
                   <br>
                   <br>
                   You can see it <a href=\"". $this->generateUrl('advert.show', array('id' => $advert->getId(), 'slug' => $advert->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL) .
                   "\">here</a>";

        $mail->setSender($sender)
             ->setReceiver($rating->getUser())
             ->setSubject($subject)
             ->setMessage($message)
             ->setBody($this->renderView(
                                            'communication\toUserEmail.html.twig', 
                                            ['mail' => $mail]
                                        )
                      )
        ;

        if($mail->sendEmail($mailer))
        {

            $manager->persist($mail);
            $manager->flush();

        }

        // Send an email to the evaluated user        
        $mail = new Mail();
        $owner = $advert->getOwner()->getUser();
        $subject = $this->getParameter('new_rating_subject');

        if($rating->getUser() === $owner)
        {

            $receiver = $rating->getBooking()->getUser();

        }
        else 
        {

            $receiver = $owner;

        }
        
        $message = "A rating about your booking from " . $rating->getBooking()->getFormattedBeginAt() . " to " . $rating->getBooking()->getFormattedEndAt() . 
                   " for the advert \"" . $rating->getBooking()->getVehicle()->getAdvert()->getTitle() . "\" was given.
                   <br>
                   <br>
                   You can see it <a href=\"". $this->generateUrl('rating.dashboard', array(), UrlGeneratorInterface::ABSOLUTE_URL) .
                   "\">here</a>.";

        $mail->setSender($sender)
             ->setReceiver($receiver)
             ->setSubject($subject)
             ->setMessage($message)
             ->setBody($this->renderView(
                                            'communication\toUserEmail.html.twig', 
                                            ['mail' => $mail]
                                        )
                      )
        ;

        if($mail->sendEmail($mailer))
        {

            $manager->persist($mail);
            $manager->flush();

        }
            
        return $this->redirectToRoute('backend.rating.toApprove');
        
    }

    /**
     * Response removing
     * 
     * @Route("/backend/rating/response/delete/{id}", name="backend.rating.response.delete", methods = "DELETE")
     * 
     * @param ResponseToRating $responseToRating
     * @param UserRepository $userRepository
     * @param Request $request
     * @param ObjectManager $manager
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function deleteResponse(ResponseToRating $responseToRating, UserRepository $userRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        if ($this->isCsrfTokenValid('delete'. $responseToRating->getId(), $request->get('_token'))) 
        {

            $rating = $responseToRating->getRating();
            
            $rating->setResponseToRating(null);
            
            $manager->persist($rating);
            $manager->remove($responseToRating);

            $mail = new Mail();
        
            $sender = $userRepository->findOneBy(array('username'=> 'administrator'));

            $message = "Your response message following the " . $responseToRating->getRating()->getUser()->getFirstname() . "'s rating didn't respect the Roadtripr's rules. 
                        So, it's removed.<br>
                        However, you can leave a new response respecting the Roadtripr rules using your <a href=\"". 
                        $this->generateUrl('rating.dashboard', array(), UrlGeneratorInterface::ABSOLUTE_URL) .
                        "\">ratings dashboard</a>";
    
            $mail->setSender($sender)
                 ->setReceiver($responseToRating->getUser())
                 ->setSubject($this->getParameter('removed_rating_response_subject'))
                 ->setMessage($message)
                 ->setBody($this->renderView(
                                                'communication\toUserEmail.html.twig', 
                                                ['mail' => $mail]
                                            )
                          )
            ;
    
            if($mail->sendEmail($mailer))
            {
    
                $manager->persist($mail);
    
            }

            $manager->flush();

            $this->addFlash('success', "The response was successfully removed."); 

        } 
            
        return $this->redirectToRoute('backend.rating.toApprove');
        
    }

    /**
     * Response approving
     * 
     * @Route("/backend/rating/response/approve/{id}", name="backend.rating.response.approve")
     * 
     * @param ResponseToRating $responseToRating
     * @param UserRepository $userRepository
     * @param Request $request
     * @param ObjectManager $manager
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function approveResponse(ResponseToRating $responseToRating, UserRepository $userRepository, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {

        $responseToRating->setApproved(true);
        
        $manager->persist($responseToRating);

        $this->addFlash('success', "The response was successfully updated.");

        $responseMail = new Mail();
        
        $sender = $userRepository->findOneBy(array('username'=> 'administrator'));
            
        $message = "Your response message following the " . $responseToRating->getRating()->getUser()->getFirstname() . "'s rating was approved. 
                    So, you can see it on your <a href=\"". 
                    $this->generateUrl('rating.dashboard', array(), UrlGeneratorInterface::ABSOLUTE_URL) .
                    "\">ratings dashboard</a>";

        $responseMail->setSender($sender)
             ->setReceiver($responseToRating->getUser())
             ->setSubject($this->getParameter('approved_rating_response_subject'))
             ->setMessage($message)
             ->setBody($this->renderView(
                                            'communication\toUserEmail.html.twig', 
                                            ['mail' => $responseMail]
                                        )
                      )
        ;

        if($responseMail->sendEmail($mailer))
        {

            $manager->persist($responseMail);

        }

        $ratingMail = new Mail();
        
        $sender = $userRepository->findOneBy(array('username'=> 'administrator'));
            
        $message = "A response to your rating about your bokking from " . $responseToRating->getRating()->getBooking()->getFormattedBeginAt() . " to" .
                    $responseToRating->getRating()->getBooking()->getFormattedEndAt() . " was posted.<br><br>
                    So, you can see it on your <a href=\"". $this->generateUrl('rating.dashboard', array(), UrlGeneratorInterface::ABSOLUTE_URL) .
                    "\">ratings dashboard</a>";

        $ratingMail->setSender($sender)
                   ->setReceiver($responseToRating->getRating()->getUser())
                   ->setSubject($this->getParameter('response_rating_subject'))
                   ->setMessage($message)
                   ->setBody($this->renderView(
                                                'communication\toUserEmail.html.twig', 
                                                ['mail' => $responseMail]
                                              )
                            )
        ;

        if($ratingMail->sendEmail($mailer))
        {

            $manager->persist($ratingMail);

        }
        
        $manager->flush();
            
        return $this->redirectToRoute('backend.rating.toApprove');
        
    }

}