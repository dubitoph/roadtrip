<?php

namespace App\Controller\backend;

use App\Entity\rating\Rating;
use App\Repository\rating\RatingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendRatingController extends AbstractController
{
    
    /**
     * @Route("/backend/rating/toAppove", name="backend.rating.toApprove")
     * @param RatingRepository $ratingRepository
     * @return Response
     */
    public function ratingsToApprove(RatingRepository $ratingRepository): Response
    {
     
        $ratings = $ratingRepository->findBy(
                                                array('ratingApproved' => false),
                                                array('createdAt' => 'asc')
                                            )
        ;
    
        return $this->render('backend/rating/index.html.twig', compact('ratings'));  
        
    }

    /**
     * @Route("/backend/rating/delete/{id}", name="backend.rating.delete", methods = "DELETE")
     * @param Rating $rating
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Rating $rating, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $rating->getId(), $request->get('_token'))) 
        {

            $manager->remove($rating);
            $manager->flush();

            $this->addFlash('success', "L'évaluation a été supprimée avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.rating.toApprove');
        
    }

}