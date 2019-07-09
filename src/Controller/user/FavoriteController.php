<?php

namespace App\Controller\user;

use App\Repository\advert\PhotoRepository;
use App\Repository\advert\AdvertRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavoriteController extends AbstractController
{
    
    /**
     * @Route("/user/favorites", name="user.favorites")
     * @param FavoriteRepository $favoriteRepository
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

        dump($userLatitude);
        
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

}