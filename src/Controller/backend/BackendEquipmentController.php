<?php

namespace App\Controller\backend;

use App\Entity\backend\Equipment;
use App\Form\backend\EquipmentType;
use App\Repository\backend\EquipmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendEquipmentController extends AbstractController
{
    
    /**
     * Equipments list
     * 
     * @Route("/backend/equipments", name="backend.equipment.index")
     * @param EquipmentRepository $equipmentRepository
     * @return Response
     */
    public function index(EquipmentRepository $equipmentRepository): Response
    {
     
        $equipments = $equipmentRepository->findAll();
    
        return $this->render('backend/equipment/index.html.twig', compact('equipments'));  
        
    }

    /**
     * Create an equipment
     * 
     * @Route("/backend/equipment/create", name="backend.equipment.create")
     * 
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $equipment = new Equipment;

        $form = $this->createForm(EquipmentType::class, $equipment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($equipment);
            $manager->flush();    

            $this->addFlash('success', "The equipment was successfully created.");      

            return $this->redirectToRoute('backend.equipment.index');
        }
     
        return $this->render('backend/equipment/new.html.twig', [
                                                                    'equipment' => $equipment,
                                                                    'form' => $form->createView(),
                                                                ]
                            )
        ;        
    }

    /**
     * Edit a equipment
     * 
     * @Route("/backend/equipment/edit/{id}", name="backend.equipment.edit")
     * 
     * @param Equipment $equipment
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function edit(Equipment $equipment, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(EquipmentType::class, $equipment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "The equipment was successfully updated.");                   

            return $this->redirectToRoute('backend.equipment.index');
        }
     
        return $this->render('backend/equipment/edit.html.twig', [
                                                                    'equipment' => $equipment,
                                                                    'form' => $form->createView(),
                                                                 ]
                            )
        ;  
        
    }

    /**
     * Delete an equipment
     * 
     * @Route("/backend/equipment/delete/{id}", name="backend.equipment.delete", methods = "DELETE")
     * 
     * @param Equipment $equipment
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function delete(Equipment $equipment, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $equipment->getId(), $request->get('_token'))) 
        {

            $manager->remove($equipment);
            $manager->flush();

            $this->addFlash('success', "The equipment was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.equipment.index');
        
    }
}