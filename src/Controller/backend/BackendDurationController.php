<?php

namespace App\Controller\backend;

use App\Entity\backend\Duration;
use App\Form\backend\DurationType;
use App\Repository\backend\DurationRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendDurationController extends AbstractController
{
    
    /**
     * @Route("/backend/durations", name="backend.duration.index")
     * @param DurationRepository $durationRepository
     * @return Response
     */
    public function index(DurationRepository $durationRepository): Response
    {
     
        $durations = $durationRepository->findAll();
    
        return $this->render('backend/duration/index.html.twig', compact('durations'));  
        
    }

    /**
     * @Route("/backend/duration/create", name="backend.duration.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $duration = new Duration;

        $form = $this->createForm(DurationType::class, $duration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($duration);
            $manager->flush();    

            $this->addFlash('success', "La durée a été créée avec succès.");      

            return $this->redirectToRoute('backend.duration.index');
        }
     
        return $this->render('backend/duration/new.html.twig', [
                                                                'duration' => $duration,
                                                                'form' => $form->createView(),
                                                               ]
                            )
        ;        
    }

    /**
     * @Route("/backend/duration/{id}", name="backend.duration.edit")
     * @param Duration $duration
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Duration $duration, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(DurationType::class, $duration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "La durée a été modifiée avec succès.");                   

            return $this->redirectToRoute('backend.duration.index');
        }
     
        return $this->render('backend/duration/edit.html.twig', [
                                                                    'duration' => $duration,
                                                                    'form' => $form->createView(),
                                                                ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/duration/delete/{id}", name="backend.duration.delete", methods = "DELETE")
     * @param Duration $duration
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Duration $duration, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $duration->getId(), $request->get('_token'))) {

            $manager->remove($duration);
            $manager->flush();

            $this->addFlash('success', "La durée a été supprimée avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.duration.index');
        
    }
}