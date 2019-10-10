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
     * Durations list
     * 
     * @Route("/backend/durations", name="backend.duration.index")
     * 
     * @param DurationRepository $durationRepository
     * 
     * @return Response
     */
    public function index(DurationRepository $durationRepository): Response
    {
     
        $durations = $durationRepository->findAll();
    
        return $this->render('backend/duration/index.html.twig', compact('durations'));  
        
    }

    /**
     * Create a duration
     * 
     * @Route("/backend/duration/create", name="backend.duration.create")
     * 
     * @param DurationRepository $durationRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function new(DurationRepository $durationRepository, Request $request, ObjectManager $manager): Response
    {

        $duration = new Duration;

        $missingDurations = $this->getMissingDuration($durationRepository);

        $form = $this->createForm(DurationType::class, $duration, array('missingDurations' => $missingDurations));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($duration);
            $manager->flush();    

            $this->addFlash('success', "The duration was successfully created.");      

            return $this->redirectToRoute('backend.duration.index');
        }
     
        return $this->render('backend/duration/new.html.twig', [
                                                                'duration' => $duration,
                                                                'form' => $form->createView()
                                                               ]
                            )
        ;        
    }

    /**
     * Edit a duration
     * 
     * @Route("/backend/duration/{id}", name="backend.duration.edit")
     * 
     * @param Duration $duration
     * @param DurationRepository $durationRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function edit(Duration $duration, DurationRepository $durationRepository, Request $request, ObjectManager $manager): Response
    {

        $missingDurations = $this->getMissingDuration($durationRepository);

        // Add current duration's days number to the missing durations
        $daysNumber = $duration->getDaysNumber();
        $missingDurations[$daysNumber] = $daysNumber;
        
        $form = $this->createForm(DurationType::class, $duration, array('missingDurations' => $missingDurations));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "The duration was successfully updated.");                   

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
     * Delete a duration
     * 
     * @Route("/backend/duration/delete/{id}", name="backend.duration.delete", methods = "DELETE")
     * 
     * @param Duration $duration
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function delete(Duration $duration, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $duration->getId(), $request->get('_token'))) {

            $manager->remove($duration);
            $manager->flush();

            $this->addFlash('success', "The duration was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.duration.index');
        
    }

    /**
     * Get missing durations
     *
     * @param DurationRepository $durationRepository
     * 
     * @return array
     */
    private function getMissingDuration(DurationRepository $durationRepository)
    {

        $existingDurations = $durationRepository->findAll();

        $daysNumber = array();

        foreach ($existingDurations as $existingDuration) 
        {

            $daysNumber[] = $existingDuration->getDaysNumber();

        }

        $missingDurations = array();

        for ($i=1; $i < 32; $i++) 
        { 

            if (! in_array($i, $daysNumber)) 
            {

                $missingDurations[$i] = $i;

            }

        }

        return $missingDurations;

    }
}