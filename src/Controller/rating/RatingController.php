<?php

namespace App\Controller\rating;

use App\Entity\advert\Advert;
use App\Entity\rating\Rating;
use App\Form\rating\RatingType;
use App\Entity\communication\Mail;
use App\Form\rating\RatingResponseType;
use App\Repository\rating\RatingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\user\UserRepository;

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
    
        return $this->render('rating/index.html.twig', compact('ratings'));  
        
    }

    /**
     * @Route("/rating/advert/create/{id}", name="rating.advert.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Advert $advert, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
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

            $rating->setAdvert($advert);
            $rating->setType('Advert');
            $rating->setUser($user);

            $form = $this->createForm(RatingType::class, $rating);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {            

                $manager->persist($rating);
                $manager->flush();    

                $this->addFlash('success', "L'évaluation a été créée avec succès et est en attente d'approbation par un administrateur pour sa publication"); 

                $mail = $this->sendRatingMail($rating, $mailer);

                if($mail)
                {                

                    $manager->persist($mail);
                    $manager->flush();

                    $this->addFlash('success', "Un email a été envoyé à l'adresse email indiquée afin d'activer votre compte.");

                }
                else
                {

                    $this->addFlash('notice', "Un email n'a pas pu être envoyé à l'adresse email indiquée afin d'activer votre compte.");

                }                    

                if ($advert) 
                {

                    return $this->redirectToRoute('advert.show', ['slug' => $advert->getSlug(), 'id' => $advert->getId()]);

                }
                else 
                {

                    return $this->redirectToRoute('rating.user', ['id' => $user->getId()]);

                }

            }
        
            return $this->render('rating/new.html.twig', [
                                                            'rating' => $rating,
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
        
            return $this->render('rating/show.html.twig', [
                                                            'rating' => $rating,
                                                            'form' => $form->createView(),
                                                          ]
                                )
            ; 

        } 
        else 
        {
        
            return $this->render('rating/show.html.twig', ['rating' => $rating]);

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
     
        return $this->render('rating/edit.html.twig', [
                                                        'rating' => $rating,
                                                        'form' => $form->createView(),
                                                      ]
                            )
        ;  
        
    }

    /**
     * @Route("/rating/owner/approval{id}", name="rating.owner.approval")
     */
    public function ownerApproval(Rating $rating, ObjectManager $manager)
    {

        $rating->setOwnerApproval(true);
            
        $manager->persist($rating);
        $manager->flush(); 

        return $this->redirectToRoute('rating.show', ['id' => $rating->getId()]);
    
    }

    /**
     * @Route("/rating/rental/confirmation/{id}/{confirmation}", name="rating.rental.confirmation", defaults={"id": 1, "confirmation": null})
     */
    public function rentalConfirmation(Rating $rating, $confirmation, ObjectManager $manager, \Swift_Mailer $mailer, UserRepository $userRepository)
    {

        if (! $rating->getRentalConfirmation()) 
        {
            
            $rating->setRentalConfirmation($confirmation);
            
            $manager->persist($rating);
            $manager->flush();

            if($confirmation == 'Yes')
            {

                $mail = $this->sendConfirmedRentalMail($rating, $mailer, $userRepository);

            }
            else
            {

                $mail = $this->sendNotConfirmedRentalMail($rating, $mailer);

                if($mail)
                {                

                    $manager->persist($mail);
                    $manager->flush();

                }
     
                return $this->render('Rating/notConfirmedRental.html.twig', ['rating' => $rating]);

            }
        }
        else
        {

            $this->addFlash('notice', "Un suivi a déjà été apporté par rapport la location. Il n'est donc plus possible de le modifier."); 

        }

        return $this->redirectToRoute('rating.show', ['id' => $rating->getId()]);
    
    }

    private function sendRatingMail($rating, $mailer)
    { 

        $mail = new Mail;
        $advert = null;

        if ($rating->getType() == 'Advert') 
        {

            $advert = $rating->getAdvert();
            $receiver = $advert->getOwner()->getUser();
            
        }
        else
        {

            $receiver = $rating->getTenant();

        }
            
        $mail->setReceiver($receiver)
             ->setSubject($this->getParameter('rating_email_subject'))
             ->setFirstname($this->getParameter('administrateur_firstname'))
             ->setName($this->getParameter('administrateur_name'))
             ->setEmailFrom($this->getParameter('administrateur_email'))
             ->setTemplate('communication\ratingEmail.html.twig')
             ->setMessage($this->renderView(
                                                $mail->getTemplate(), 
                                                [
                                                    'tenant' => $this->getUser(), 
                                                    'receiver' => $receiver, 
                                                    'rating' => $rating, 
                                                    'advert' => $advert
                                                ]
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

    private function sendConfirmedRentalMail($rating, $mailer, $userRepository)
    { 

        $mail = new Mail;
        $receiver = $userRepository->findOneBy(array('username' => $this->getParameter('backend_admin_user')));
            
        $mail->setReceiver($receiver)
             ->setSubject($this->getParameter('rating_approval_subject'))
             ->setFirstname($this->getParameter('administrateur_firstname'))
             ->setName($this->getParameter('administrateur_name'))
             ->setEmailFrom($this->getParameter('administrateur_email'))
             ->setTemplate('backend\rating\ratingToApproveEmail.html.twig')
             ->setMessage($this->renderView(
                                                $mail->getTemplate(), 
                                                ['rating' => $rating]
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

    private function sendNotConfirmedRentalMail($rating, $mailer)
    { 

        $mail = new Mail;
            
        $mail->setReceiver($rating->getUser())
             ->setSubject($this->getParameter('rating_not_confirmed_rental_email_subject'))
             ->setFirstname($this->getParameter('administrateur_firstname'))
             ->setName($this->getParameter('administrateur_name'))
             ->setEmailFrom($this->getParameter('administrateur_email'))
             ->setTemplate('communication\notConfirmedRentalEmail.html.twig')
             ->setMessage($this->renderView(
                                                $mail->getTemplate(), 
                                                [
                                                    'rating' => $rating,
                                                    'contestationEmail' => $this->getParameter('contestation_email')
                                                ]
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