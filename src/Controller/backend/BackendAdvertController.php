<?php

namespace App\Controller\backend;

use App\Repository\advert\AdvertRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendAdvertController extends AbstractController
{
    
    /**
     * @Route("/backend/adverts", name="backend.advert.index")
     * @param AdvertRepository $advertRepository
     * @return Response
     */
    public function index(AdvertRepository $advertRepository): Response
    {
     
        $adverts = $advertRepository->findAll();
    
        return $this->render('backend/advert/index.html.twig', compact('adverts'));  
        
    }

}