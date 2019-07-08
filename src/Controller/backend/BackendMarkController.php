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
     * @Route("/backend/marks", name="backend.mark.index")
     * @param MarkRepository $markRepository
     * @return Response
     */
    public function index(MarkRepository $markRepository): Response
    {
     
        $marks = $markRepository->findAll();
    
        return $this->render('backend/mark/index.html.twig', compact('marks'));  
        
    }

    /**
     * @Route("/backend/mark/create", name="backend.mark.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $mark = new Mark;

        $form = $this->createForm(MarkType::class, $mark);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($mark);
            $manager->flush();    

            $this->addFlash('success', "La marque de véhicule a été créée avec succès.");      

            return $this->redirectToRoute('backend.mark.index');
        }
     
        return $this->render('backend/mark/new.html.twig', [
                                                            'mark' => $mark,
                                                            'form' => $form->createView(),
                                                           ]
                            )
        ;        
    }

    /**
     * @Route("/backend/mark/edit/{id}", name="backend.mark.edit")
     * @param Mark $mark
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Mark $mark, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(MarkType::class, $mark);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "La marque de véhicule a été modifiée avec succès.");                   

            return $this->redirectToRoute('backend.mark.index');
        }
     
        return $this->render('backend/mark/edit.html.twig', [
                                                                'mark' => $mark,
                                                                'form' => $form->createView(),
                                                            ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/mark/delete/{id}", name="backend.mark.delete", methods = "DELETE")
     * @param Mark $mark
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Mark $mark, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $mark->getId(), $request->get('_token'))) {

            $manager->remove($mark);
            $manager->flush();

            $this->addFlash('success', "La marque de véhicule a été supprimée avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.mark.index');
        
    }
}