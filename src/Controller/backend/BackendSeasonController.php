<?php

namespace App\Controller\backend;

use App\Entity\backend\Season;
use App\Form\backend\SeasonType;
use App\Repository\backend\SeasonRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendSeasonController extends AbstractController
{
    
    /**
     * @Route("/backend/seasons", name="backend.season.index")
     * @param SeasonRepository $seasonRepository
     * @return Response
     */
    public function index(SeasonRepository $seasonRepository): Response
    {
     
        $seasons = $seasonRepository->findAll();
    
        return $this->render('Backend/season/index.html.twig', array(
                                                                        'seasons' => $seasons,
                                                                        'bodyId' => 'seasonsIndex'
                                                                    )
                            )
        ;  
        
    }

    /**
     * @Route("/backend/season/create", name="backend.season.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $season = new Season;

        $form = $this->createForm(seasonType::class, $season);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($season);
            $manager->flush();    

            $this->addFlash('success', "La saison a été créée avec succès.");      

            return $this->redirectToRoute('backend.season.index');
        }
     
        return $this->render('backend/season/new.html.twig', [
                                                                'season' => $season,
                                                                'bodyId' => 'seasonsCreation',
                                                                'form' => $form->createView(),
                                                             ]
                            )
        ;        
    }

    /**
     * @Route("/backend/season/edit/{id}", name="backend.season.edit")
     * @param Season $season
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Season $season, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(SeasonType::class, $season);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "La saison a été modifiée avec succès.");                   

            return $this->redirectToRoute('backend.season.index');
        }
     
        return $this->render('backend/season/edit.html.twig', [
                                                                'season' => $season,
                                                                'bodyId' => 'seasonsEdition',
                                                                'form' => $form->createView(),
                                                              ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/season/delete/{id}", name="backend.season.delete", methods = "DELETE")
     * @param Season $season
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Season $season, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $season->getId(), $request->get('_token'))) {

            $manager->remove($season);
            $manager->flush();

            $this->addFlash('success', "La saison a été supprimée avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.season.index');
        
    }
}