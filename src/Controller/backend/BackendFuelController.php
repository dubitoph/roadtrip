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
     * Fuels list
     * 
     * @Route("/backend/fuels", name="backend.fuel.index")
     * 
     * @param FuelRepository $fuelRepository
     * 
     * @return Response
     */
    public function index(FuelRepository $fuelRepository): Response
    {
     
        $fuels = $fuelRepository->findAll();
    
        return $this->render('backend/fuel/index.html.twig', array(
                                                                    'fuels' => $fuels,
                                                                    'bodyId' => 'fuelIndex'
                                                                  )
                            )
        ;  
        
    }

    /**
     * Create a fuel
     * 
     * @Route("/backend/fuel/create", name="backend.fuel.create")
     * 
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $fuel = new Fuel;

        $form = $this->createForm(FuelType::class, $fuel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {            

            $manager->persist($fuel);
            $manager->flush();    

            $this->addFlash('success', "The fuel was successfully created.");      

            return $this->redirectToRoute('backend.fuel.index');

        }
     
        return $this->render('backend/fuel/new.html.twig', [
                                                            'fuel' => $fuel,
                                                            'bodyId' => 'fuelCreation',
                                                            'form' => $form->createView()
                                                           ]
                            )
        ;        
    }

    /**
     * Edit a fuel
     * 
     * @Route("/backend/fuel/edit/{id}", name="backend.fuel.edit")
     * 
     * @param Fuel $fuel
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function edit(Fuel $fuel, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(FuelType::class, $fuel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {           

            $manager->flush();

            $this->addFlash('success', "The fuel was successfully updated.");                   

            return $this->redirectToRoute('backend.fuel.index');
        }
     
        return $this->render('backend/fuel/edit.html.twig', [
                                                                'fuel' => $fuel,
                                                                'bodyId' => 'fuelEdition',
                                                                'form' => $form->createView()
                                                            ]
                            )
        ;  
        
    }

    /**
     * Remove a fuel
     * 
     * @Route("/backend/fuel/delete/{id}", name="backend.fuel.delete", methods = "DELETE")
     * 
     * @param Fuel $fuel
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function delete(Fuel $fuel, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $fuel->getId(), $request->get('_token'))) 
        {

            $manager->remove($fuel);
            $manager->flush();

            $this->addFlash('success', "The fuel was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.fuel.index');
        
    }
    
}