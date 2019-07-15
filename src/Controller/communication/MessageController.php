<?php

namespace App\Controller\communication;

use App\Entity\communication\Mail;
use App\Entity\communication\Thread;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\communication\MailRepository;
use App\Repository\communication\ThreadRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        
        $notReadUserMessages = $mailRepository->notReadMessages($user, null);
        $notReadOwnerMessages = $mailRepository->notReadMessages(null, $owner);

        return $this->render('user/threads.html.twig', [
                                                            'user' => $user,
                                                            'notReadUserMessages' => $notReadUserMessages,
                                                            'notReadOwnerMessages' => $notReadOwnerMessages
                                                       ]
                            )
        ;  
        
    }

    /**
     * @Route("/communication/create/{id}", name="communication.create")
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

                $manager->persist($mail);
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