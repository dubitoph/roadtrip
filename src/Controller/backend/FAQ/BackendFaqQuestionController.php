<?php

namespace App\Controller\backend\FAQ;

use App\Entity\backend\FAQ\FaqQuestion;
use App\Form\backend\FAQ\FaqQuestionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\backend\FAQ\FaqQuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendFaqQuestionController extends AbstractController
{
    
    /**
     * Questions list
     * 
     * @Route("/backend/FAQ/question/index", name="backend.FAQ.question.index")
     * 
     * @param FaqQuestionRepository $faqQuestionRepository
     * 
     * @return Response
     */
    public function index(FaqQuestionRepository $faqQuestionRepository): Response
    {
     
        $faqQuestions = $faqQuestionRepository->findAll();
    
        return $this->render('backend/faq/question/index.html.twig', array(
                                                                            'faqQuestions' => $faqQuestions,
                                                                            'bodyId' => 'faqQuestionsIndex'
                                                                          )
                            )
        ;  
        
    }

    /**
     * Create a FAQ question
     * 
     * @Route("/backend/FAQ/question/create", name="backend.FAQ.question.create")
     * 
     * @param FaqQuestionRepository $faqQuestionRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $faqQuestion = new FaqQuestion;

        $form = $this->createForm(FaqQuestionType::class, $faqQuestion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {            

            $manager->persist($faqQuestion);
            $manager->flush();    

            $this->addFlash('success', "The question was successfully created.");      

            return $this->redirectToRoute('backend.FAQ.question.index');
        }
     
        return $this->render('backend/faq/question/new.html.twig', [
                                                                     'form' => $form->createView(),
                                                                     'bodyId' => 'faqQuestionCreation'
                                                                   ]
                            )
        ;        
    }

    /**
     * Edit a question
     * 
     * @Route("/backend/FAQ/question/{id}", name="backend.FAQ.question.edit")
     * 
     * @param FaqQuestion $faqQuestion
     * @param FaqQuestionRepository $faqQuestionRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function edit(FaqQuestion $faqQuestion, FaqQuestionRepository $faqQuestionRepository, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(FaqQuestionType::class, $faqQuestion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {           

            $manager->flush();

            $this->addFlash('success', "The question was successfully updated.");                   

            return $this->redirectToRoute('backend.FAQ.question.index');
        }
     
        return $this->render('backend/faq/question/edit.html.twig', [
                                                                        'bodyId' => 'faqQuestionEdition',
                                                                        'form' => $form->createView(),
                                                                    ]
                            )
        ;  
        
    }

    /**
     * Delete a question
     * 
     * @Route("/backend/FAQ/question/delete/{id}", name="backend.FAQ.question.delete", methods = "DELETE")
     * 
     * @param FaqQuestion $faqQuestion
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function delete(FaqQuestion $faqQuestion, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $faqQuestion->getId(), $request->get('_token'))) 
        {

            $manager->remove($faqQuestion);
            $manager->flush();

            $this->addFlash('success', "The question was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.FAQ.question.index');
        
    }
    
}