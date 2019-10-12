<?php

namespace App\Controller\backend;

use App\Entity\backend\Mark;
use App\Form\backend\MarkType;
use App\Repository\backend\MarkRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendMarkController extends AbstractController
{
    
    /**
     * Marks list
     * 
     * @Route("/backend/marks", name="backend.mark.index")
     * 
     * @param MarkRepository $markRepository
     * 
     * @return Response
     */
    public function index(MarkRepository $markRepository): Response
    {
     
        $marks = $markRepository->findAll();
    
        return $this->render('backend/mark/index.html.twig', array(
                                                                    'marks' => $marks,
                                                                    'bodyId' => 'marksIndex'
                                                                  )
                            )
        ;  
        
    }

    /**
     * Create a mark
     * 
     * @Route("/backend/mark/create", name="backend.mark.create")
     * 
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $mark = new Mark;

        $form = $this->createForm(MarkType::class, $mark);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {            

            $manager->persist($mark);
            $manager->flush();    

            $this->addFlash('success', "The mark was successfully created.");      

            return $this->redirectToRoute('backend.mark.index');
        }
     
        return $this->render('backend/mark/new.html.twig', [
                                                            'mark' => $mark,
                                                            'bodyId' => 'marksCreation',
                                                            'form' => $form->createView()
                                                           ]
                            )
        ;        
    }

    /**
     * Edit a mark
     * 
     * @Route("/backend/mark/edit/{id}", name="backend.mark.edit")
     * 
     * @param Mark $mark
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function edit(Mark $mark, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(MarkType::class, $mark);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {           

            $manager->flush();

            $this->addFlash('success', "The mark was successfully updated.");                   

            return $this->redirectToRoute('backend.mark.index');

        }
     
        return $this->render('backend/mark/edit.html.twig', [
                                                                'mark' => $mark,
                                                                'bodyId' => 'marksEdition',
                                                                'form' => $form->createView()
                                                            ]
                            )
        ;  
        
    }

    /**
     * Remove a mark
     * 
     * @Route("/backend/mark/delete/{id}", name="backend.mark.delete", methods = "DELETE")
     * 
     * @param Mark $mark
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function delete(Mark $mark, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $mark->getId(), $request->get('_token'))) 
        {

            $manager->remove($mark);
            $manager->flush();

            $this->addFlash('success', "The mark was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.mark.index');
        
    }
}