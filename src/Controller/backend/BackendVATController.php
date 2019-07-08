<?php

namespace App\Controller\backend;

use App\Entity\backend\VAT;
use App\Form\backend\VATType;
use App\Repository\backend\VATRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendVATController extends AbstractController
{
    
    /**
     * @Route("/backend/VAT_All", name="backend.VAT.index")
     * @param VATRepository $VATRepository
     * @return Response
     */
    public function index(VATRepository $VATRepository): Response
    {
     
        $allVAT = $VATRepository->findAll();
    
        return $this->render('backend/VAT/index.html.twig', compact('allVAT'));  
        
    }

    /**
     * @Route("/backend/VAT/create", name="backend.VAT.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $VAT = new VAT;

        $form = $this->createForm(VATType::class, $VAT);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($VAT);
            $manager->flush();    

            $this->addFlash('success', "La TVA a été créée avec succès.");      

            return $this->redirectToRoute('backend.VAT.index');
        }
     
        return $this->render('backend/VAT/new.html.twig', [
                                                                'VAT' => $VAT,
                                                                'form' => $form->createView(),
                                                               ]
                            )
        ;        
    }

    /**
     * @Route("/backend/VAT/{id}", name="backend.VAT.edit")
     * @param VAT $VAT
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(VAT $VAT, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(VATType::class, $VAT);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "La TVA a été modifiée avec succès.");                   

            return $this->redirectToRoute('backend.VAT.index');
        }
     
        return $this->render('backend/VAT/edit.html.twig', [
                                                                    'VAT' => $VAT,
                                                                    'form' => $form->createView(),
                                                                ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/VAT/delete/{id}", name="backend.VAT.delete", methods = "DELETE")
     * @param VAT $VAT
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(VAT $VAT, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $VAT->getId(), $request->get('_token'))) {

            $manager->remove($VAT);
            $manager->flush();

            $this->addFlash('success', "La TVA a été supprimée avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.VAT.index');
        
    }
}