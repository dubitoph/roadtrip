<?php

namespace App\Controller\communication;

use App\Entity\user\User;
use App\Entity\advert\Advert;
use App\Entity\communication\Mail;
use App\Entity\communication\Thread;
use App\Form\communication\MailType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\communication\ThreadRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\communication\MailRepository;

class MessageController extends AbstractController
{
    
    /**
     * @Route("/communication/messages", name="communication.messages")
     * @return Response
     */
    public function index(ThreadRepository $threadRepository, MailRepository $mailRepository): Response
    {
     
        $user = $this->getUser(); 
        $owner = $user->getOwner();
        $notReadOwnerMessages = array();
        
        $results = $threadRepository->notReadMessages($user, null);
        
        foreach ($results as $result) 
        {
           
            $notReadUserMessages[$result['thread']] = $result['number'];

        }

        if ($owner) 
        {
        
            $results = $threadRepository->notReadMessages(null, $owner);
            
            foreach ($results as $result) 
            {
               
                $notReadOwnerMessages[$result['thread']] = $result['number'];
    
            }

        }       
        
        $adminMails = $mailRepository->findBy(
                                                array(
                                                        'receiver'=> $user, 
                                                        'thread' => null, 
                                                        'booking' => null
                                                     ),
                                                array('createdAt' => 'desc')
                                             )
        ;

        return $this->render('user/messages.html.twig', [
                                                            'user' => $user,
                                                            'notReadUserMessages' => $notReadUserMessages,
                                                            'notReadOwnerMessages' => $notReadOwnerMessages,
                                                            'adminMails' => $adminMails
                                                       ]
                            )
        ;
        
    }

    /**
     * Mail creation
     * 
     * @Route("/communication/mail/create/{id}/{receiver}", name="communication.mail.create")
     * @param Advert $advert
     * @param User $receiver
     * @param Request $request
     * @param ObjectManager $manager
     * @param \Swift_Mailer $mailer
     * 
     * @return Response
     */
    public function createMail(Advert $advert, User $receiver, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {  
        
        $thread = new Thread();        
        $mail = new Mail();
        $owner = $advert->getOwner(); 

        $mail->setSender($this->getUser())
             ->setReceiver($receiver)
             ->setSubject('')
             ->setMessage('')
             ->setBody('The body')
             ->setThread($thread)
        ;

        $thread->setAdvert($advert)
               ->setUser($receiver)
               ->setOwner($owner)
               ->addMail($mail)
        ;

        $form = $this->createForm(MailType::class, $mail, array('existingSubject' => false));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $mail->setBody($this->renderView(
                                                'communication/mail.html.twig', 
                                                ['mail' => $mail]
                                            )
                          )
            ;

            if ($mail->sendEmail($mailer))
            {                

                $manager->persist($thread);
                $manager->flush();

                $this->addFlash('success', "Your message was sent.");

            }
            else
            {

                $this->addFlash('error', "Your message couldn't be sent.");

            }

            $url = $request->request->get('referer');
            
            if ($url == NULL) 
            {

                return $this->redirectToRoute('home');
            } 
            else 
            {

                return $this->redirect($url);

            }


        }
     
        return $this->render('communication/createMail.html.twig', [
                                                                    'mail' => $mail,
                                                                    'form' => $form->createView(),
                                                                   ]
                            )
        ;

    }

    /**
     * @Route("/communication/create/follow-up/{id}", name="communication.create.follow-up")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Thread $thread, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {               
        
        $message = $request->get('response_thread_' . $thread->getId());
        
        if (strlen($message) >= 10) 
        {
        
            $currentUser = $this->getUser();
            $owner = $thread->getAdvert()->getOwner()->getUser();
            $mail = new Mail();

            if ($currentUser == $owner) 
            {

                $receiver = $thread->getUser();

            }
            else 
            {

                $receiver = $currentUser;

            }
            
            $mail->setSender($currentUser)
                 ->setReceiver($receiver)
                 ->setSubject($this->getParameter('thread_subject'))
                 ->setThread($thread)
                 ->setMessage($message)
                 ->setBody($this->renderView(
                                                'communication/threadFollow-Up.html.twig', 
                                                ['mail' => $mail]
                                               )
                            )
            ;

            if ($mail->sendEmail($mailer))
            {                

                $manager->persist($thread);
                $manager->flush();

                $this->addFlash('success', "Your message was sent.");

            }
            else
            {

                $this->addFlash('error', "Your message couldn't be sent.");

            }
        }
        else 
        {

            $this->addFlash('error', "Your message must contain at least 10 characters.");

        }

         return $this->redirectToRoute('communication.messages');

    }

    /** 
     * @Route("/communication/mail/update/read", name="communication.mail.update.read") 
     */ 
    public function ajaxAction(Request $request, ObjectManager $manager, ThreadRepository $threadRepository) 
    {
        if($request->isXmlHttpRequest())
        {
            
            $threadId = $request->request->get('threadId');
            
            $thread = $threadRepository->find($threadId);

            foreach ($thread->getMails() as $mail) 
            {

                if (! $mail->getIsRead() and $mail->getSender() != $this->getUser()) 
                {

                    $mail->setIsRead(true);

                }

            }

            $manager->persist($thread);
            $manager->flush();
             
            $response = new JsonResponse();
            $response->setData(array('success'=> 'Mails updated')); 

            return $response;
        }
        else
        {

            $response = new JsonResponse();
            $response->setData(array('error'=> 'Mails not updated'));
            return $response;
         
        }

    }

}