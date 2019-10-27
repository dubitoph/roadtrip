<?php

namespace App\Controller\faq;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\backend\FAQ\FaqCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FaqController extends AbstractController
{
    
    /**
     * All questions by category
     * 
     * @Route("/faq/index", name="faq.index")
     * 
     * @param FaqCategoryRepository $faqCategoryRepository
     * 
     * @return Response
     */
    public function index(FaqCategoryRepository $faqCategoryRepository): Response
    {
     
        $faqCategories = $faqCategoryRepository->findAll();
    
        return $this->render('faq/index.html.twig', array(
                                                            'faqCategories' => $faqCategories,
                                                            'bodyId' => 'faqIndex'
                                                         )
                            )
        ;  
        
    }
    
}