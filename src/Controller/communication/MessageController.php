<?php

namespace App\Controller\communication;

use App\Entity\communication\Mail;
use App\Entity\communication\Thread;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\communication\ThreadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    
    /**
     * @Route("/communication/messages", name="communication.messages")
     * @return Response
     */
    public function index(ThreadRepository $threadRepository): Response
    {
     
        $user = $this->getUser();

        return $this->render('user/threads.html.twig', [
                                                            'user' => $user
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
        
            $mail = new Mail();
            
            $mail->setSender($this->getUser())
                 ->setReceiver($thread->getAdvert()->getOwner()->getUser())
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

}