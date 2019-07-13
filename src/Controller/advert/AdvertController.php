<?php

namespace App\Controller\advert;

use App\Entity\backend\VAT;
use App\Entity\advert\Price;
use App\Entity\advert\Advert;
use App\Entity\advert\Vehicle;
use App\Form\advert\CostsType;
use App\Form\advert\AdvertType;
use App\Entity\advert\Insurance;
use App\Entity\backend\Duration;
use App\Form\advert\VehicleType;
use App\Entity\communication\Mail;
use App\Entity\advert\AdvertSearch;
use App\Entity\backend\Subscription;
use App\Form\communication\MailType;
use App\Entity\advert\InsurancePrice;
use App\Form\advert\AdvertSearchType;
use App\Form\advert\PricesAdvertType;
use Symfony\Component\Form\FormError;
use App\Entity\advert\IncludedMileage;
use App\Form\advert\PeriodsAdvertType;
use App\Entity\communication\Thread;
use App\Repository\advert\PhotoRepository;
use App\Repository\advert\AdvertRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdvertController extends AbstractController
{
    
    /**
     * @Route("/adverts", name="advert.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, AdvertRepository $advertRepository, PhotoRepository $photoRepository, Request $request): Response
    {

        $search = $this->container->get('session')->get('search');

        $this->container->get('session')->remove('search');

        if ($search === null || !$search instanceof AdvertSearch) 
        {

            $search = new AdvertSearch();

        }

        $form = $this->createForm(AdvertSearchType::class, $search);
        $form->handleRequest($request);

        $results = array();
        $distances = array();
        
        $results = $advertRepository->findSearchedAdverts($search);
        
        $adverts = array();            
        $minPrices = array();            
        $distances = array();
        
        foreach ($results as $result) 
        {
            if(is_array($result))
            {
                
                $adverts[] = $result[0];
                $advertId = $result[0]->getId();
            
                if(array_key_exists('minPrice', $result)) 
                {

                    $minPrices[$advertId] = round($result["minPrice"]);

                }
            
                if(array_key_exists('distance', $result)) 
                {

                    $distances[$advertId] = round($result["distance"], 2);

                }

            }
            else
            {

                $adverts[] = $result;

            }

        }
        
        $adverts = $paginator->paginate($adverts, 
                                        $request->query->getInt('page', 1), 
                                        12
                                       )
        ;

        $mainPhotos = array();

        if ($adverts->count() > 0) 
        {
        
            $mainPhotos = $photoRepository->getMainPhotos($adverts);

        }

        return $this->render('advert/index.html.twig', [
                                                        'current_menu' => 'adverts',
                                                        'adverts' => $adverts,
                                                        'distances' => $distances,
                                                        'minPrices' => $minPrices,
                                                        'form' => $form->createView(),
                                                        'mainPhotos' => $mainPhotos,
                                                        'userCity' => $search->getCity()
                                                       ]
                            )
        ;

    }

    /**
     * @Route("/advert/create", name="advert.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $advert = new Advert();

        $form = $this->createForm(AdvertType::class, $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
                
            $advert->setCreatedAt(new \DateTime('now'));
            $advert->setExpiresAt(new \DateTime($advert->getCreatedAt()->format('Y-m-d H:i:s') . " +" . $this->getParameter('advert_active_duration')));           

            $manager->persist($advert);
            $manager->flush();   
            $this->addFlash('success', 'La première partie de votre annonce a été créée avec succès.');       

            return $this->redirectToRoute('advert.vehicle.management', array('id' => $advert->getId()));
        }
     
        return $this->render('advert/new.html.twig', [
                                                        'advert' => $advert,
                                                        'current_menu' => 'add_advert',
                                                        'form' => $form->createView(),
                                                     ]
                            )
        ; 
        
    }

    /**
     *  @Route("/advert/vehicle/management/{id}", name="advert.vehicle.management")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function vehicleForm(Advert $advert, Request $request, ObjectManager $manager) {

        $vehicle = $advert->getVehicle();
        $editMode = true;
        
        if (! $vehicle) 
        {

            $vehicle = new Vehicle();
            $advert->setVehicle($vehicle);
            $editMode = false;

        }

        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 

            $equipments = $vehicle->getEquipments();

            foreach ($equipments as $equipment) 
            {

                $equipment->addVehicle($vehicle);

            }

            $cellEquipments = $form->get("cellEquipments")->getData();

            foreach ($cellEquipments as $cellEquipment) 
            {

                $vehicle->addEquipment($cellEquipment);

            }
                
            $manager->persist($advert);
            $manager->flush();   

            if ($editMode) 
            {

                $this->addFlash('success', 'Le véhicule a été modifié avec succès.');

            }
            else
            {

                $this->addFlash('success', 'Le véhicule a été ajouté à votre annonce avec succès.');

            }             
            
            return $this->redirectToRoute('advert.photos.management', array('id' => $advert->getId()));

        }

        return $this->render('advert/vehicle.html.twig', [
                                                            'vehicle' => $vehicle,
                                                            'form' => $form->createView(),
                                                         ]
                            )
        ;

    }

    /**
     *  @Route("/advert/periods/management/{id}", name="advert.periods.management")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function periodsForm(Advert $advert, Request $request, ObjectManager $manager) {

        $numberPeriods = count($advert->getPeriods());
        $editMode = false;

        if ($numberPeriods > 0) 
        {

            $editMode = true;

        }

        $form = $this->createForm(PeriodsAdvertType::class, $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            //They will be used to check if overlaps in the periods
            $periods = $advert->getPeriods();

            $overlap = false;

            //They will be used to check if the periods are valid (between today and the fixed limit in the parameters)
            $format = 'Y-m-d H:i:s';
            $date = date("Y-m-d 00:00:00");
            $toDay = \DateTime::createFromFormat($format, $date);
            $upLimitDate = new \DateTime("+ " . $this->getParameter('limit_creation_periods'));
            $previousLimit = false;
            $overLimit = false;
            $oldestDate = new \DateTime("+ 10 years");
            $mostDistantDate = new \DateTime("- 10 years");

            foreach ($periods as $period) {

                //Checking if there is a date older than today
                if ($period->getStart() < $toDay) {

                    $previousLimit = true;

                }

                //Checking if there is a date most distant than the duration fixed in the parameters
                if ($period->getEnd() > $upLimitDate) {

                    $overLimit = true;

                }

                //Checking if there are overlaps in the periods
                foreach ($periods as $periodChecked) {

                if ($period !== $periodChecked) {

                    if (! ($period->getEnd() < $periodChecked->getStart() || $period->getStart() > $periodChecked->getEnd()))
                        {

                            $overlap = true;

                        }
                        
                    }

                }

            }  

            if ($overlap) {
                $error = new FormError("Des périodes se chevauchent. Veuillez vérifier les dates de début et de fin.");
                $form->addError($error);
            }

            if ($previousLimit) {
                $error = new FormError("Les périodes ne peuvent pas débuter avant ce jour. Veuillez vérifier les dates de début.");
                $form->addError($error);
            }

            if ($overLimit) {
                $error = new FormError("Les périodes ne peuvent pas être planifiées plus de " . $this->getParameter('limit_creation_periods') . 
                                       " à l'avance. Veuillez vérifier les dates de début et de fin.");
                $form->addError($error);
            }

            //End of overlaps and invalid periods check           

            //Checking if they are gaps during the laps covered by the different periods

            $endCkeckedPeriod = new \DateTime("+ " . $this->getParameter('minimum_creation_periods'));
            $interval = new \DateInterval('P1D');
            $daysCovered = array();

            foreach ($periods as $period) {
                
                $startDate = $period->getStart();
                $endDate = $period->getEnd();
                $end = clone $endDate;
                $modifiedEndDate = $endDate->modify( '+1 day' );
                    
                $daterange = new \DatePeriod($startDate, $interval, $endDate);
                    
                if (($startDate >= $toDay && $startDate <= $endCkeckedPeriod) || ($end >= $toDay && $end <= $endCkeckedPeriod)) {
                    
                    foreach ($daterange as $periodDate) {

                        if ( $periodDate >= $toDay && $periodDate <= $endCkeckedPeriod) {

                            $daysCovered[] = $periodDate;

                        }
                            
                    }

                }

            }

            $dayDate = clone $toDay;
            $gaps = true;

            while (in_array($dayDate, $daysCovered) && $dayDate <= $endCkeckedPeriod) 
            {

                $dayDate->modify( '+1 day' );

            }

            if ($dayDate >= $endCkeckedPeriod) {
                
                $gaps = false;

            }

            if ($gaps) 
            {

                $error = new FormError("Il existe des jours non couverts pour la prochaine période de " . $this->getParameter('minimum_creation_periods'));
                $form->addError($error);
                
            }

            //End of gaps check

            $manager->persist($advert);
            $manager->flush();  

            if ($editMode) 
            {

                $this->addFlash('success', 'Les périodes ont été modifiées avec succès.');

            }
            else
            {

                $this->addFlash('success', 'Les périodes ont été ajoutées à votre annonce avec succès.');

            }

            return $this->redirectToRoute('advert.prices.management', array('id' => $advert->getId()));

        }
  
        return $this->render('advert/periods.html.twig', [
                                                            'form' => $form->createView(), 
                                                            'editMode' => $numberPeriods > 0
                                                         ]
                            )
        ;

    }

    /**
     *  @Route("/advert/prices/management/{id}", name="advert.prices.management")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function pricesForm(Advert $advert, Request $request, ObjectManager $manager) { 

        $editMode = false;
        
        //Preparation of the prices list in function of the number different seasons  
        $missingDurations = array();
        $durations = $manager->getRepository(Duration::class)->findAll();

        //Search seasons used by periods
        foreach ($advert->getPeriods() as $key => $value) {

            $seasons[] = $value->getSeason();

        }

        $unique_seasons = array_unique($seasons);
        //End of search seasons used by periods

        $prices = $advert->getPrices();
        

        if (count($prices) > 0) {

            $editMode = true;

            foreach ($prices as $price) 
            {
    
                $idsSeasonsPrices[] = $price->getSeason()->getId();

            }

            //For each season, searching missing duration compared to parameter to permit add only not existing durations
            foreach ($unique_seasons as $unique_season) 
            {
    
                $seasonPrices = $unique_season->getPrices();

                $missingDurations[''. $unique_season->getSeason() . ''] = array();
                $seasonDurations = array();
    
                foreach($seasonPrices as $seasonPrice) 
                {
                    
                    $seasonDurations[] = $seasonPrice->getDuration();
                
                }
                    
                foreach ($durations as $duration) 
                {
                        
                    if (! in_array($duration, $seasonDurations)) 
                    {
                            
                        $missingDurations[''. $unique_season->getSeason() . ''][] = $duration;
    
                    }
    
              }
           
            }

        }
        else 
        {
            
            $editMode = false;

            $numberSeasons = count($unique_seasons);

            //Prices creation
            foreach ($unique_seasons as $unique_season) 
            {
 
                foreach ($durations as $duration) 
                {

                    $price = new Price;
                    $price->setDuration($duration);
                    $price->setSeason($unique_season);
                    $advert->addPrice($price);                    
                    $idsSeasonsPrices[] = $unique_season->getId();

                }

            }

        }
    
        $form = $this->createForm(PricesAdvertType::class, $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
           
            $manager->persist($advert);
            $manager->flush();  

            if ($editMode) 
            {

                $this->addFlash('success', 'Les prix ont été modifiés avec succès.');

            }
            else
            {

                $this->addFlash('success', 'Les prix ont été ajoutés à votre annonce avec succès.');

            }

            return $this->redirectToRoute('advert.costs.management', array('id' => $advert->getId()));

        }
  
        return $this->render('advert/prices.html.twig', [
                                                            'form' => $form->createView(), 
                                                            'unique_seasons' => $unique_seasons, 
                                                            'idsSeasonsPrices' => $idsSeasonsPrices,  
                                                            'editMode' => $editMode,
                                                            'missingDurations' => $missingDurations, 
                                                            'configuredDurations' => $durations,
                                                        ]
                            )
        ;

    }

    /**
     *  @Route("/advert/costs/management/{id}", name="advert.costs.management")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function costsForm(Advert $advert = null, Request $request, ObjectManager $manager)
    {

        $insurance = $advert->getInsurance();
        $prices = $advert->getPrices();
        $numberMileages = count($advert->getIncludedMileages());
        $editMode = true;

        if ((! $insurance) && ($numberMileages == 0) && (!$advert->getExtraKilometerCost()) && (!$advert->getIncludedCleaning()) && (!$advert->getCleaningCost())) 
        {

            $editMode = false;

        }

        foreach ($prices as $price) 
        {

            $durations[] = $price->getDuration();

        }

        $unique_durations = array_unique($durations);
        
        if (! $insurance) {

            $insurance = new Insurance();
            $advert->setInsurance($insurance);

        }

        if (! $insurance || count($insurance->getInsurancePrices()) == 0) 
        {

            foreach ($unique_durations as $unique_duration) 
            {

                $insurancePrice = new InsurancePrice();
                $insurancePrice->setDuration($unique_duration);
                $insurance->addInsurancePrice($insurancePrice);

            }

        }

        if ($numberMileages == 0) 
        {

            foreach ($unique_durations as $unique_duration) 
            {

                $includedMileage = new IncludedMileage();
                $includedMileage->setDuration($unique_duration);
                $advert->addIncludedMileage($includedMileage);

            }

        }

        $insurancePrices = $insurance->getInsurancePrices();
        $includedMileages = $advert->getIncludedMileages();

        $idInsurancePricesDurations = array();

        foreach ($insurancePrices as $insurancePrice) 
        {

            $idInsurancePricesDurations[] = $insurancePrice->getDuration()->getId();

        }

        $idIncludedMileagesDurations = array();

        foreach ($includedMileages as $includedMileage) 
        {

            $idIncludedMileagesDurations[] = $includedMileage->getDuration()->getId();

        }
        
       $form = $this->createForm(CostsType::class, array(
                                                            'insurance' => $insurance,
                                                            'insurancePrices' => $insurancePrices,
                                                            'includedMileages' => $includedMileages,
                                                            'extraKilometerCost' => $advert, 
                                                            'cleaning' => $advert, 
                                                        )
                                )
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        { 

            $insurance->setIncluded($form['insurance']['included']->getData());
            $insurance->setDeductible($form['insurance']['deductible']->getData());
            
            $i = 0;
            $insuranceIncluded = $insurance->getIncluded();

            foreach ($insurancePrices as $insurancePrice) 
            {

                if ($insuranceIncluded) {

                    $insurance->removeInsurancePrice($insurancePrice);

                }
                else 
                {

                    $price = $form['insurancePrices'][$i]['price']->getData();
                    $insurancePrice->setPrice($price);

                }

                $i++;

            }
            
            $j = 0;

            foreach ($includedMileages as $includedMileage) 
            {

                $mileage = $form['includedMileages'][$j]['mileage']->getData();
                $includedMileage->setMileage($mileage);
                $j++;

            }

            $advert->setExtraKilometerCost($form['extraKilometerCost']['extraKilometerCost']->getData());

            $includedCleaning = $form['cleaning']['includedCleaning']->getData();
            $advert->setIncludedCleaning($includedCleaning);

            if ($includedCleaning) 
            {

                $advert->setCleaningCost(null);

            }
            else 
            {

                $advert->setCleaningCost($form['cleaning']['cleaningCost']->getData());

            }            
            
            $manager->persist($advert);
            $manager->flush();  

            if ($editMode) 
            {

                $this->addFlash('success', 'Les coûts ont été modifiés avec succès.');

            }
            else
            {

                $this->addFlash('success', 'Les coûts ont été ajoutés à votre annonce avec succès.');

            } 

            if ($this->container->get('security.authorization_checker')->isGranted('ROLE_OWNER') || $advert->getOwner())
            {

                return $this->redirectToRoute('advert.subscription.management', array('id' => $advert->getId()));

            }

            return $this->redirectToRoute('user.owner.create', array('id' => $advert->getId()));

        }

        return $this->render('advert/costs.html.twig', [
                                                            'form' => $form->createView(), 
                                                            'unique_durations' => $unique_durations, 
                                                            'insurancePrices' => $insurancePrices, 
                                                            'includedMileages' => $includedMileages, 
                                                            'idInsurancePricesDurations' => $idInsurancePricesDurations, 
                                                            'idIncludedMileagesDurations' => $idIncludedMileagesDurations, 
                                                            'editMode' => $insurance->getId() !== null,
                                                       ]
                            )
        ;        
    }

    /**
     *  @Route("/advert/subscription/management/{id}", name="advert.subscription.management")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function subscriptionForm(Advert $advert = null, Request $request, ObjectManager $manager)
    {

        $subscriptions = $manager->getRepository(Subscription::class)->findAll(); 
        
        $vat = $manager->getRepository(VAT::class)->findOneBy(array('abbreviation' => $advert->getOwner()->getBillingAddress()->getCountry()));
        
        return $this->render('advert/subscription.html.twig', [
                                                                'advert' => $advert,
                                                                'subscriptions' => $subscriptions,
                                                                'vat' => $vat
                                                              ]
                            )
        ;
    }

    /**
     * @Route("/advert/subscription/set/{id}", name="advert.subscription.set", methods = "UPDATE")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function setSubscription(Advert $advert, Request $request, ObjectManager $manager): Response
    {

        $token = $request->get('_token');
        $subscriptionId = $request->get('subscriptionId');
        
        if ($this->isCsrfTokenValid('update'. $subscriptionId, $token)) 
        {

            $subscription = $manager->getRepository(Subscription::class)->find($subscriptionId);

            $advert->setSubscription($subscription);
            
            $manager->persist($advert);
            $manager->flush();

            $this->addFlash('success', "Le type d'abonnement a été enregistré avec succès.");  
            
            return $this->redirectToRoute('payment.payment', array('id' => $advert->getId()));

        }        

        $this->addFlash('error', "Un problème technique est survenu : le type d'abonnement n'a pas pu être enregistré.");  
            
        return $this->redirectToRoute('advert.subscription.management', array('id' => $advert->getId()));
        
    }
    
    /**
     * @Route("/advert/show/{slug}-{id}", name="advert.show", requirements = {"slug": "[a-z0-9\-]*"})
     */
    public function show(Advert $advert, String $slug, PhotoRepository $photoRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response 
    {
        
        $user = $this->getUser();
        $receiver = $advert->getOwner()->getUser();
        $advertSlug = $advert->getSlug();
        
        if ($advertSlug !== $slug) 
        {

            return $this->redirectToRoute('all.advert.show', ['id' => $advert->getId(),
                                                              'slug' => $advertSlug,
                                                             ],
                                                             301 
                                         )
            ;

        }
        
        $thread = new Thread();

        $thread->setAdvert($advert)
               ->setCreator($user)
        ;        

        $mail = new Mail();

        $mail->setSender($user)
             ->setReceiver($receiver)
             ->setSubject($this->getParameter('contact_owner_subject'))
             ->setThread($thread)
             ->setBody('The body');

        $minPrice = $this->getMinPrice($advert);
        $mainPhoto = $photoRepository->findOneBy(array('advert' => $advert, 'mainPhoto' => true));

        $cellEquipments = array();
        $carrierEquipments = array();

        foreach($advert->getVehicle()->getEquipments() as $equipment)
        {

            if ($equipment->getBelonging() === 'Cellule') 
            {

                $cellEquipments[] = $equipment;

            }
            else
            {

                $carrierEquipments[] = $equipment;

            }

        }

        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $mail->setBody($this->renderView(
                                                'communication/threadFollow-Up.html.twig', 
                                                [
                                                    'mail' => $mail
                                                ]
                                            )
                          )
            ;

            if ($mail->sendEmail($mailer))
            {                

                $manager->persist($thread);
                $manager->persist($mail);
                $manager->flush();

                $this->addFlash('success', "Your message was successfully send.");

            }
            else
            {

                $this->addFlash('error', "Your message couldn't be sent");

            }

            return $this->redirectToRoute('advert.show', [
                                                            'id' => $advert->getId(),
                                                            'slug' => $advertSlug,
                                                         ]
                                         )
            ;

        }
        
        return $this->render('advert/show.html.twig', [
                                                        'current_menu' => 'adverts', 
                                                        'controller_name' => 'AdvertController', 
                                                        'advert' => $advert,
                                                        'minPrice' => $minPrice,
                                                        'mainPhoto' => $mainPhoto,
                                                        'cellEquipments' => $cellEquipments,
                                                        'carrierEquipments' => $carrierEquipments,
                                                        'form' => $form->createView(),
                                                      ]
                            )
    ;

    }

    /**
     * @Route("/advert/edit/{id}", name="advert.edit")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Advert $advert, Request $request, ObjectManager $manager): Response
    {

        $form = $this->createForm(AdvertType::class, $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {           

            $manager->flush();
            $this->addFlash('success', 'Votre annonce a bien été modifiée');                   

            return $this->redirectToRoute('advert.vehicle.management', array('id' => $advert->getId()));
        }
     
        return $this->render('advert/edit.html.twig', [
                                                        'advert' => $advert,
                                                        'form' => $form->createView(),
                                                      ]
                            )
        ;  
        
    }

    /**
     * @Route("/advert/delete/{id}", name="advert.delete", methods = "DELETE")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Advert $advert, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $advert->getId(), $request->get('_token'))) 
        {

            $manager->remove($advert);
            $manager->flush();
            $this->addFlash('success', 'Votre annonce a bien été supprimée'); 

        } 
            
        return $this->redirectToRoute('backend.advert.index');
        
    }

    public function getMinPrice($advert)
    {

        $minPrices = $this->getDoctrine()->getRepository(Price::class)->getAdvertMinPrice($advert);

        if(count($minPrices) > 0) 
        {
            $minPrice = $minPrices[0];
        }
        else 
        {

            $minPrice = null;

        }

        return  $minPrice;

    }

}
