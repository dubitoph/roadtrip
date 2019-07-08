<?php

namespace App\Controller\backend;

use App\Entity\backend\Fuel;
use App\Form\backend\FuelType;
use App\Repository\backend\FuelRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendFuelController extends AbstractController
{
    
    /**
     * @Route("/backend/fuels", name="backend.fuel.index")
     * @param FuelRepository $fuelRepository
     * @return Response
     */
    public function index(FuelRepository $fuelRepository): Response
    {
     
        $fuels = $fuelRepository->findAll();
    
        return $this->render('backend/fuel/index.html.twig', compact('fuels'));  
        
    }

    /**
     * @Route("/backend/fuel/create", name="backend.fuel.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $fuel = new Fuel;

        $form = $this->createForm(FuelType::class, $fuel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($fuel);
            $manager->flush();    

            $this->addFlash('success', "Le type de carburant a été créé avec succès.");      

            return $this->redirectToRoute('backend.fuel.index');
        }
     
        return $this->render('backend/fuel/new.html.twig', [
                                                            'fuel' => $fuel,
                                                            'form' => $form->createView(),
                                                           ]
                            )
        ;        
    }

    /**
     * @Route("/backend/fuel/edit/{id}", name="backend.fuel.edit")
     * @param Fuel $fuel
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Fuel $fuel, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(FuelType::class, $fuel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "Le type de carburant a été modifié avec succès.");                   

            return $this->redirectToRoute('backend.fuel.index');
        }
     
        return $this->render('backend/fuel/edit.html.twig', [
                                                                'fuel' => $fuel,
                                                                'form' => $form->createView(),
                                                            ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/fuel/delete/{id}", name="backend.fuel.delete", methods = "DELETE")
     * @param Fuel $fuel
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Fuel $fuel, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $fuel->getId(), $request->get('_token'))) {

            $manager->remove($fuel);
            $manager->flush();

            $this->addFlash('success', "Le type de carburant a été supprimé avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.fuel.index');
        
    }
}