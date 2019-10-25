<?php

namespace App\Controller\backend\FAQ;

use App\Entity\backend\FAQ\FaqCategory;
use App\Form\backend\FAQ\FaqCategoryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\backend\FAQ\FaqCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendFaqCategoryController extends AbstractController
{
    
    /**
     * Categories list
     * 
     * @Route("/backend/FAQ/category/index", name="backend.FAQ.category.index")
     * 
     * @param FaqCategoryRepository $faqCategoryRepository
     * 
     * @return Response
     */
    public function index(FaqCategoryRepository $faqCategoryRepository): Response
    {
     
        $faqCategories = $faqCategoryRepository->findAll();
    
        return $this->render('backend/faq/category/index.html.twig', array(
                                                                            'faqCategories' => $faqCategories,
                                                                            'bodyId' => 'faqCategoriesIndex'
                                                                          )
                            )
        ;  
        
    }

    /**
     * Create a FAQ category
     * 
     * @Route("/backend/FAQ/category/create", name="backend.FAQ.category.create")
     * 
     * @param FaqCategoryRepository $faqCategoryRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $faqCategory = new FaqCategory;

        $form = $this->createForm(FaqCategoryType::class, $faqCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {            

            $manager->persist($faqCategory);
            $manager->flush();    

            $this->addFlash('success', "The category was successfully created.");      

            return $this->redirectToRoute('backend.FAQ.category.index');
        }
     
        return $this->render('backend/faq/category/new.html.twig', [
                                                                     'form' => $form->createView(),
                                                                     'bodyId' => 'faqCategoryCreation'
                                                                   ]
                            )
        ;        
    }

    /**
     * Edit a category
     * 
     * @Route("/backend/FAQ/category/{id}", name="backend.FAQ.category.edit")
     * 
     * @param FaqCategory $faqCategory
     * @param FaqCategoryRepository $faqCategoryRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function edit(FaqCategory $faqCategory, FaqCategoryRepository $faqCategoryRepository, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(FaqCategoryType::class, $faqCategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {           

            $manager->flush();

            $this->addFlash('success', "The category was successfully updated.");                   

            return $this->redirectToRoute('backend.FAQ.category.index');
        }
     
        return $this->render('backend/faq/category/edit.html.twig', [
                                                                        'bodyId' => 'faqCategoryEdition',
                                                                        'form' => $form->createView(),
                                                                    ]
                            )
        ;  
        
    }

    /**
     * Delete a category
     * 
     * @Route("/backend/FAQ/category/delete/{id}", name="backend.FAQ.category.delete", methods = "DELETE")
     * 
     * @param FaqCategory $faqCategory
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function delete(FaqCategory $faqCategory, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $faqCategory->getId(), $request->get('_token'))) 
        {

            $manager->remove($faqCategory);
            $manager->flush();

            $this->addFlash('success', "The category was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.FAQ.category.index');
        
    }
    
}