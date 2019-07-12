<?php

namespace App\Controller\user;

use App\Repository\communication\MailRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    
    /**
     * @Route("/user/messages", name="user.messages")
     * @return Response
     */
    public function index(MailRepository $mailRepository): Response
    {
     
        $user = $this->getUser();        
        $messages = $mailRepository->findMailsAboutAdvert($user);

        return $this->render('user/messages.html.twig', [
                                                            'messages' => $messages
                                                        ]
                            )
        ;  
        
    }

}