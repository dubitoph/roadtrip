<?php

namespace App\Controller\home;

use App\Entity\advert\AdvertSearch;
use App\Repository\media\PhotoRepository;
use App\Repository\advert\AdvertRepository;
use App\Repository\rating\RatingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\advert\AdvertSimplifiedSearchType;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\backend\SubscriptionRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * Homepage
     * 
     * @Route("/", name="home")
     *
     * @param Request $request
     * @param AdvertRepository $advertRepository
     * @param RatingRepository $ratingRepository
     * @param SubscriptionRepository $subscriptionRepository
     * @param PhotoRepository $photoRepository
     * @return Response
     */
    public function index(Request $request, AdvertRepository $advertRepository, RatingRepository $ratingRepository, 
                          SubscriptionRepository $subscriptionRepository, PhotoRepository $photoRepository): Response
    { 

        $results = array();
        
        $results = $advertRepository->lasAdverts();
        
        $lastAdverts = array();            
        $minPrices = array(); 
        
        foreach ($results as $result) 
        {
            if(is_array($result))
            {
                
                $lastAdverts[] = $result[0];
                $lastAdvertId = $result[0]->getId();
            
                if(array_key_exists('minPrice', $result)) 
                {

                    $minPrices[$lastAdvertId] = round($result["minPrice"]);

                }

            }
            else
            {

                $lastAdverts[] = $result;

            }

        }

        $mainPhotos = array();

        if (count($lastAdverts) > 0) 
        {
        
            $mainPhotos = $photoRepository->getMainPhotos($lastAdverts);

        }       
        
        $lastAdvertRatings = $ratingRepository->findBy(
                                                        array('ratingApproved' => true),
                                                        array('createdAt' => 'DESC'),
                                                        $limit  = 10
                                                      )
        ;

        $subscriptions = $subscriptionRepository->findAll();
           
        $search = new AdvertSearch();
        //Set the default value for the minimum beds number select
        $search->setMinimumBedsNumber(4);

        $userAddress = $this->container->get('session')->get('userAddress');

        if ($userAddress)
        {

            $search->setAddress($userAddress)
                   ->setCity($this->container->get('session')->get('userCity'))
                   ->setLongitude($this->container->get('session')->get('userLongitude'))
                   ->setLatitude($this->container->get('session')->get('userLatitude'))
            ;

        }

        $filesNames = array();
        $imagesDirectory = $this->getParameter('home_page_images_directory');
        
        if ($handle = opendir($imagesDirectory));
        {
            while (false !== ($entry = readdir($handle))) 
            {

                if ($entry != '.' && $entry != '..') 
                {

                    $filesNames[] = $entry;
                
                }
                

            }

            foreach ($filesNames as &$fileName) 
            {

                $fileName = $imagesDirectory . '/' . $fileName;

            }

            closedir($handle);

        }

        $form = $this->createForm(AdvertSimplifiedSearchType::class, $search, array('url' => $this->generateUrl('user.geolocation.session', [], UrlGeneratorInterface::ABSOLUTE_URL)));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            // If availibility filter is reused, uncomment
/*  
            $beginAt = $search->getBeginAt();
            
            if($beginAt)
            {

                $beginAt->setTime('12', '0', '0');

            } 
      
            $endAt = $search->getEndAt();
                
            if($endAt)
            {
    
                $endAt->setTime('11', '59', '59');
    
            }
*/            
            $this->container->get('session')->set('search', $search);

            return $this->redirectToRoute('advert.index');

        }
        
        return $this->render('home/home.html.twig', [
                                                      'filesNames' => $filesNames,
                                                      'lastAdverts' => $lastAdverts,
                                                      'minPrices' => $minPrices,
                                                      'mainPhotos' => $mainPhotos,
                                                      'lastAdvertRatings' => $lastAdvertRatings,
                                                      'subscriptions' => $subscriptions,
                                                      'bodyId' => 'homepage',
                                                      'form' => $form->createView()
                                                   ]
                            )
        ;
        
    }
}
