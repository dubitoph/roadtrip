<?php

namespace App\Controller\backend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendController extends AbstractController
{
    
    /**
     * Backend access interface
     * 
     * @Route("/backend", name="backend")
     * 
     * @return Response
     */
    public function index(): Response
    {
     
        return $this->render('backend/index.html.twig', array('bodyId' => 'backendDashboard'));  
        
    }

}