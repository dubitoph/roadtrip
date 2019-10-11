<?php

namespace App\Controller\user;

use App\Entity\user\User;
use App\Entity\user\Owner;
use App\Form\user\OwnerType;
use App\Entity\advert\Advert;
use App\Entity\communication\Mail;
use App\Repository\user\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserOwnerController extends AbstractController
{
    
    /**
     * @Route("/user/owner/create/{id}", name="user.owner.create")
     *
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function new(
                            Advert $advert = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, 
                            \Swift_Mailer $mailer, UserRepository $userRepository
                        ): Response
    {

        $user = $this->getUser();
        $isAdmin = $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN');
        $newUser = false;
        
        $owner = new Owner();

        if($advert)
        {

            $advert->setOwner($owner);

        }
        
        if (! $user) 
        {

            $user = new User();

            $user->setRoles(['ROLE_OWNER']);

            $newUser = true;
            
        }            

        $user->setOwner($owner);        
        $user->setRoles(['ROLE_OWNER']);
        
        $VehicleSituation = $advert->getVehicle()->getSituation();

        if (! $VehicleSituation) 
        {

            $billingAddress = new Address();

        }
        else
        {

            $billingAddress = clone $VehicleSituation;

        }
        
        $owner->setBillingAddress($billingAddress);
        
        $form = $this->createForm(OwnerType::class, $owner, array('isAdmin' => $isAdmin, 'user' => $user));
 
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) 
        {  
            
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            if (null !== $request->request->get('phone_number')) 
            {

                $user->setPhoneNumber($request->request->get('phone_number'));

            }
                        
            $manager->persist($owner);
            $manager->flush(); 

            if($newUser)
            {  

                $mail = new Mail;

                $administrator = $userRepository->findOneBy(array('name' => 'administrator'));

                $mail->setReceiver($user)
                     ->setSubject($this->getParameter('registration_email_subject'))
                     ->setSender($administrator)
                     ->setMessage('Account creation')
                     ->setBody($this->renderView(
                                                    'security/registrationEmail.html.twig', 
                                                    ['user' => $user]
                                                )
                              )
                ;

                if ($mail->sendEmail($mailer))
                {                

                    $manager->persist($mail);
                    $manager->flush();

                    $this->addFlash('success', "An email was sent to the completed email address to activate your account.");

                }
                else
                {

                    $this->addFlash('error', "An email could not be sent to the completed email address to activate your account.");

                }

            }

            if($advert)
            {

                return $this->redirectToRoute('advert.subscription.create', array('id' => $advert->getId()));

            }

        }

        return $this->render('user/owner/owner.html.twig', array(
                                                                    'form' => $form->createView(),
                                                                    'bodyId' =>  'ownerCreation',
                                                                    'editMode' => $owner->getId() !== null
                                                                )
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

        return $this->render('user/owner/edit.html.twig', array(
                                                                    'bodyId' =>  'ownerEdition',
                                                                    'form' => $form->createView()
                                                               )
                            )
        ;

    }

}