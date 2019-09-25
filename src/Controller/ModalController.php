<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModalController extends AbstractController
{
    
    /**
     * @Route("/modal", name="modal")
     * 
     * @return Response
     */
    public function show(): Response
    {      

        return $this->render('modalTest.html.twig');        

    }

}