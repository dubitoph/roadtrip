<?php

namespace App\Controller\user;

use App\Entity\advert\Advert;
use App\Entity\user\Favorite;
use App\Repository\media\PhotoRepository;
use App\Repository\advert\AdvertRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{
    
    /**
     * @Route("/user/favorites", name="user.favorites")
     * @return Response
     */
    public function index(AdvertRepository $advertRepository, PhotoRepository $photoRepository): Response
    {
     
        $user = $this->getUser();        
        $favorites = $user->getFavorites(); 
        $favoriteAdverts = array()       ;
        
        foreach ($favorites as $favorite) 
        {

            $favoriteAdverts[] = $favorite->getAdvert();

        }

        $userLatitude = $this->container->get('session')->get('userLatitude');
        $userLongitude = $this->container->get('session')->get('userLongitude');
        
        if ($userLatitude && $userLongitude) 
        {

            $advertsToShow = $advertRepository->favorites($favoriteAdverts, $userLatitude, $userLongitude);

        }
        else
        {

            $advertsToShow = $advertRepository->favorites($favoriteAdverts);

        }
       
        
        $adverts = array();            
        $minPrices = array();            
        $distances = array();
        
        foreach ($advertsToShow as $advertToShow) 
        {
            if(is_array($advertToShow))
            {
                
                $adverts[] = $advertToShow[0];
                $advertId = $advertToShow[0]->getId();
            
                if(array_key_exists('minPrice', $advertToShow)) 
                {

                    $minPrices[$advertId] = round($advertToShow["minPrice"]);

                }
            
                if(array_key_exists('distance', $advertToShow)) 
                {

                    $distances[$advertId] = round($advertToShow["distance"], 2);

                }

            }
            else
            {

                $adverts[] = $advertToShow;

            }

        }

        $mainPhotos = array();

        if (count($adverts) > 0) 
        {
        
            $mainPhotos = $photoRepository->getMainPhotos($adverts);

        }

        return $this->render('user/favorites.html.twig', [
                                                            'adverts' => $adverts,
                                                            'distances' => $distances,
                                                            'minPrices' => $minPrices,
                                                            'mainPhotos' => $mainPhotos,
                                                            'userCity' => $this->container->get('session')->get('userCity')
                                                         ]
                            )
        ;  
        
    }

    /**
     * @Route("user/favorite/create/{id}", name="user.favorite.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Advert $advert, Request $request, ObjectManager $manager): Response
    {

        $user = $this->getUser();
        
        $favorite = new Favorite();

        $favorite->setUser($user)
                 ->setAdvert($advert);

        $manager->persist($favorite);
        $manager->flush();    

        $this->addFlash('success', "This advert is now in your favorites.");
        
        return $this->redirectToRoute('advert.show', array('id' => $advert->getId(), 'slug' => $advert->getSlug())); 

    }

    /**
     * @Route("/user/favorite/delete/{id}", name="user.favorite.delete", methods = "DELETE")
     * @param Favorite $favorite
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Favorite $favorite, Request $request, ObjectManager $manager): Response
    {

    $advert = $favorite->getAdvert();
        
        if ($this->isCsrfTokenValid('delete'. $favorite->getId(), $request->get('_token'))) 
        {

            $manager->remove($favorite);
            $manager->flush();
            $this->addFlash('success', "This advert isn't anymore in your favorites"); 

        } 
            
        return $this->redirectToRoute('advert.show', array('id' => $advert->getId(), 'slug' => $advert->getSlug()));
        
    }

}