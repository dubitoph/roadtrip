<?php

namespace App\Controller\backend;

use App\Entity\backend\Sort;
use App\Form\backend\SortType;
use App\Repository\backend\SortRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendSortController extends AbstractController
{
    
    /**
     * @Route("/backend/sorts", name="backend.sort.index")
     * @param SortRepository $sortRepository
     * @return Response
     */
    public function index(SortRepository $sortRepository): Response
    {
     
        $sorts = $sortRepository->findAll();
    
        return $this->render('backend/sort/index.html.twig', compact('sorts'));  
        
    }

    /**
     * @Route("/backend/sort/create", name="backend.sort.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $sort = new Sort;

        $form = $this->createForm(SortType::class, $sort);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($sort);
            $manager->flush();    

            $this->addFlash('success', "Le type de véhicule a été créé avec succès.");      

            return $this->redirectToRoute('backend.sort.index');
        }
     
        return $this->render('backend/sort/new.html.twig', [
                                                            'sort' => $sort,
                                                            'form' => $form->createView(),
                                                           ]
                            )
        ;        
    }

    /**
     * @Route("/backend/sort/edit/{id}", name="backend.sort.edit")
     * @param Sort $sort
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Sort $sort, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(SortType::class, $sort);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "Le type de véhicule a été modifié avec succès.");                   

            return $this->redirectToRoute('backend.sort.index');
        }
     
        return $this->render('backend/sort/edit.html.twig', [
                                                                'sort' => $sort,
                                                                'form' => $form->createView(),
                                                            ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/sort/delete/{id}", name="backend.sort.delete", methods = "DELETE")
     * @param Sort $sort
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Sort $sort, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $sort->getId(), $request->get('_token'))) {

            $manager->remove($sort);
            $manager->flush();

            $this->addFlash('success', "Le type de véhicule a été supprimé avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.sort.index');
        
    }
}