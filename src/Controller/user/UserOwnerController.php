<?php

namespace App\Controller\user;

use App\Entity\user\User;
use App\Entity\user\Owner;
use App\Form\user\OwnerType;
use App\Entity\advert\Advert;
use App\Entity\communication\Mail;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserOwnerController extends AbstractController
{
    
    /**
     *  @Route("/user/owner/create/{id}", name="user.owner.create")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Advert $advert = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer)
    {

        $user = $this->getUser();
        $isAdmin = $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        $newUser = false;
        
        $owner = new Owner();

        $advert->setOwner($owner);
        
        if (! $user) 
        {

            $user = new User();

            $user->setRoles(['ROLE_OWNER']);

            $newUser = true;
            
        }            

        $user->setOwner($owner);        
        $user->setRoles(['ROLE_OWNER']);
        
        $VehicleSituation = $advert->getVehicle()->getSituation();
        $billingAddress = clone $VehicleSituation;

        if (! $VehicleSituation) 
        {

            $billingAddress = new Address();

        }
        
        $owner->setBillingAddress($billingAddress);
        
        $form = $this->createForm(OwnerType::class, $owner, array(
                                                                    'isAdmin' => $isAdmin
                                                                 ) 
                                 )
        ;
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        {                       

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            if (null !== $request->request->get('phone_number')) 
            {

                $user->setPhoneNumber($request->request->get('phone_number'));

            }

            if ($request->request->get('address_changed') != 1) 
            {

                $owner->setBillingAddress($VehicleSituation);

            }
                        
            $manager->persist($owner);
            $manager->flush(); 

            if($newUser)
            {

                $mail = new Mail;
    
                $mail->setReceiver($user)
                     ->setSubject($this->getParameter('registration_email_subject'))
                     ->setFirstname($this->getParameter('administrateur_firstname'))
                     ->setName($this->getParameter('administrateur_name'))
                     ->setEmailFrom($this->getParameter('administrateur_email'))
                     ->setTemplate('security/registrationEmail.html.twig')
                     ->setMessage($this->renderView(
                                                    $mail->getTemplate(), 
                                                    ['user' => $user]
                                                   )
                                 )
                ;
    
                if ($mail->sendEmail($mailer))
                {                
    
                    $manager->persist($mail);
                    $manager->flush();
    
                    $this->addFlash('success', "Un email a été envoyé à l'adresse email indiquée afin d'activer votre compte.");
    
                }
                else
                {
    
                    $this->addFlash('notice', "Un email n'a pas pu être envoyé à l'adresse email indiquée afin d'activer votre compte.");
    
                }

            }

            return $this->redirectToRoute('advert.subscription.management', array('id' => $advert->getId()));

        }

        return $this->render('advert/owner.html.twig', [
                                                        'form' => $form->createView(), 
                                                        'editMode' => $owner->getId() !== null,
                                                       ]
                            )
        ;
        

    }
    
    /**
     *  @Route("/user/owner/edit", name="user.owner.edit")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Request $request, ObjectManager $manager)
    {

        $owner = $this->getUser()->getOwner();
        
        $form = $this->createForm(OwnerType::class, $owner, array(
                                                                    'user' => $this->getUser(),
                                                                 ) 
                                 )
        ;
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        {  
                        
            $manager->persist($owner);
            $manager->flush(); 

            $this->addFlash('success', "Your owner contact informations were updated.");

        }

        return $this->render('user/owner/edit.html.twig', ['form' => $form->createView()]);

    }

}