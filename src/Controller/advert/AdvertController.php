<?php

namespace App\Controller\advert;

use App\Entity\backend\VAT;
use App\Entity\advert\Price;
use App\Entity\advert\Advert;
use App\Entity\advert\Vehicle;
use App\Entity\advert\Insurance;
use App\Form\advert\VehicleType;
use App\Entity\communication\Mail;
use App\Entity\advert\AdvertSearch;
use App\Entity\backend\Subscription;
use App\Entity\communication\Thread;
use App\Form\advert\DescriptionType;
use App\Form\communication\MailType;
use App\Entity\advert\InsurancePrice;
use App\Form\advert\AdvertSearchType;
use App\Form\advert\PricesAdvertType;
use App\Form\advert\VariousCostsType;
use Symfony\Component\Form\FormError;
use App\Entity\advert\IncludedMileage;
use App\Form\advert\PeriodsAdvertType;
use App\Repository\media\PhotoRepository;
use App\Repository\advert\AdvertRepository;
use App\Repository\user\FavoriteRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\backend\SeasonRepository;
use App\Repository\booking\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\backend\DurationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AdvertController extends AbstractController
{
    
    /**
     * Adverts list after filtering
     * 
     * @Route("/adverts", name="advert.index")
     *
     * @param PaginatorInterface $paginator
     * @param AdvertRepository $advertRepository
     * @param PhotoRepository $photoRepository
     * @param BookingRepository $bookingRepository
     * @param Request $request
     * 
     * @return Response
     */
    public function index(PaginatorInterface $paginator, AdvertRepository $advertRepository, PhotoRepository $photoRepository, 
                          BookingRepository $bookingRepository, Request $request): Response
    {

        $search = $this->container->get('session')->get('search');

        if($search)
        {

            $this->container->get('session')->remove('search');

        }

        if ($search === null || !$search instanceof AdvertSearch)
        {

            $search = new AdvertSearch();
        
            //Set the default value for the minimum beds number select
            $search->setMinimumBedsNumber(4);
            $search->setMinimumPrice(10);
            $search->setMaximumPrice(60);
            $search->setDistance(100);

        }

        $form = $this->createForm(AdvertSearchType::class, $search, array('url' => $this->generateUrl('user.geolocation.session', [], UrlGeneratorInterface::ABSOLUTE_URL)));
        $form->handleRequest($request);

        return $this->render('advert/index.html.twig', [
                                                            'current_menu' => 'adverts',
                                                            'form' => $form->createView(),
                                                            'bodyId' => 'advertsIndex',
                                                            'userCity' => $search->getCity(),
                                                            'minPriceParameter' => $this->getParameter('minimum_price_search'),
                                                            'maxPriceParameter' => $this->getParameter('maximum_price_search'),
                                                            'minDistanceParameter' => $this->getParameter('minimum_distance_search'),
                                                            'maxDistanceParameter' => $this->getParameter('maximum_distance_search')
                                                       ]
                            )
        ;

    }
    
    /**
     * @Route("/advert/owner", name="advert.owner")
     * @return Response
     */
    public function ownerAdverts(PhotoRepository $photoRepository, Request $request): Response
    {
     
        $adverts = $this->getUser()->getOwner()->getAdverts();

        $mainPhotos = array();

        if (count($adverts) > 0) 
        {
        
            $mainPhotos = $photoRepository->getMainPhotos($adverts);

        }

        return $this->render('advert/ownerAdverts.html.twig', [
                                                                'adverts' => $adverts,
                                                                'locale' => $request->getLocale(),
                                                                'mainPhotos' => $mainPhotos,
                                                                'bodyId' => 'ownerAdverts'
                                                              ]
                            )
        ;  
        
    }

    /**
     * Creating and updating advert
     *
     * @Route("/advert/description/create", name="advert.description.create")
     * @Route("/advert/description/edit/{id}", name="advert.description.edit")
     * 
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function descriptionForm(Advert $advert = null, Request $request, ObjectManager $manager): Response
    {

        $editMode = true;
        $current_menu = 'dashbord';
        
        if(!$advert)
        {

            $advert = new Advert();
            $editMode = false;
            $current_menu = 'add_advert';

        }

        $form = $this->createForm(DescriptionType::class, $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {            

            $manager->persist($advert);
            $manager->flush(); 
            
            if($editMode)
            {
                
                $advert->setUpdatedAt(new \DateTime());
                $this->addFlash('success', 'Your advert title and description were successfully updated.');

            } 
            else 
            {
                
                $this->addFlash('success', 'Your advert title and description were successfully created.');

            }

            return $this->redirectToRoute('advert.vehicle.create', array('id' => $advert->getId()));

        }
     
        
        
        return $this->render('advert/descriptionCreation.html.twig', [
                                                                        'editMode' => $editMode,
                                                                        'current_menu' => $current_menu,
                                                                        'bodyId' => 'advertDescriptionCreation',
                                                                        'form' => $form->createView(),
                                                                     ]
                            )
        ; 
        
    }

    /**
     * Creating and updating vehicle data linked to the advert
     *
     * @Route("/advert/vehicle/create/{id}", name="advert.vehicle.create")
     * 
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function vehicleForm(Advert $advert, Request $request, ObjectManager $manager): Response 
    {
        
        $vehicle = $advert->getVehicle();
        $editMode = true;
        $current_menu = 'dashbord';
        
        if (! $vehicle) 
        {

            $vehicle = new Vehicle();
            $advert->setVehicle($vehicle);
            $editMode = false;
            $current_menu = 'add_advert';

        }

        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        { 

            $advert->setUpdatedAt(new \DateTime());
            
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

                $this->addFlash('success', 'Your vehicle data were successfully updated.');

            }
            else
            {

                $this->addFlash('success', 'Your vehicle data were successfully created.');

            }             
            
            return $this->redirectToRoute('media.advert_photos.create', array('id' => $advert->getId()));

        }

        return $this->render('advert/vehicleCreation.html.twig', [
                                                                    
                                                                    'current_menu' => $current_menu,
                                                                    'bodyId' => 'advertVehicleCreation',
                                                                    'form' => $form->createView()
                                                                 ]
                            )
        ;

    }

    /**
     * Creating and updating periods
     *
     * @Route("/advert/periods/create/{id}/{onlyPeriodsCreation}", name="advert.periods.create")
     * 
     * @param Advert $advert
     * @param Bool $onlyPeriodsCreation
     * @param SeasonRepository $seasonRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function periodsForm(
                                    Advert $advert, bool $onlyPeriodsCreation = false, SeasonRepository $seasonRepository, Request $request, 
                                    ObjectManager $manager
                                ): Response
    {
        
        $intl_date_formatter = new \IntlDateFormatter(
                                                        $request->getLocale(),
                                                        \IntlDateFormatter::MEDIUM,
                                                        \IntlDateFormatter::NONE
                                                     )
        ;
        
        $limitCreationPeriods = $this->getParameter('limit_creation_periods');
        $periods = $advert->getPeriods();
        $numberPeriods = count($periods);
        $editMode = false;
        $upLimitDate = new \DateTime("+ " . $limitCreationPeriods);
        $seasons = $seasonRepository->findAll();
        
        $current_menu = 'add_advert';        
        
        $format = 'Y-m-d H:i:s';
        $date = date("Y-m-d 00:00:00");
        $today = \DateTime::createFromFormat($format, $date);

        if ($numberPeriods > 0) 
        {
        
            foreach($periods as $period)
            {

                if ($period->getEnd() < $today) 
                {

                    $advert->removePeriod($period);

                }

            }

            $editMode = true;
            $current_menu = 'dasbord';

        }

        $form = $this->createForm(PeriodsAdvertType::class, $advert, array('endDate' => $upLimitDate));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $periods = $advert->getPeriods();

            if(count($periods) > 0)
            {

                //Used to check if overlaps in the periods
                $overlap = false;

                //Used to check if the periods are valid (between today and the fixed limit in the parameters)
                $previousLimit = false;
                $overLimit = false;

                foreach ($periods as $period) 
                {

                    //Checking if there is a date older than today
                    if ($period->getStart() < $today) 
                    {

                        $previousLimit = true;

                    }

                    //Checking if there is a date most distant than the duration fixed in the parameters
                    if ($period->getEnd() > $upLimitDate) 
                    {

                        $overLimit = true;

                    }

                    //Checking if there are overlaps in the periods
                    foreach ($periods as $periodChecked) 
                    {

                        if ($period !== $periodChecked) 
                        {

                            if (! ($periodChecked->getEnd() < $period->getStart() || $periodChecked->getStart() > $period->getEnd()))
                            {

                                $overlap = true;

                            }
                            
                        }

                    }

                }

                if ($overlap) 
                {

                    $error = new FormError("Periods overlap. Please check the start and end dates.");
                    $form->addError($error);

                }

                if ($previousLimit)
                {

                    $error = new FormError("Periods can not begin before this day. Please check the start dates.");
                    $form->addError($error);

                }

                if ($overLimit) 
                {

                    $error = new FormError("Periods can not be scheduled more than " . $this->getParameter('limit_creation_periods') . 
                                           " in advance. Please check the start and end dates.");
                    $form->addError($error);

                }           

                //Checking if they are gaps until the minimum date
                $endCkeckedPeriod = new \DateTime("+ " . $this->getParameter('minimum_creation_periods'));
                $interval = new \DateInterval('P1D');
                $daysCovered = array();

                foreach ($periods as $period) 
                {
                    
                    $startDate = $period->getStart();
                    $endDate = $period->getEnd();
                    $end = clone $endDate;
                        
                    $daterange = new \DatePeriod($startDate, $interval, $endDate);
                        
                    if (($startDate >= $today && $startDate <= $endCkeckedPeriod) || ($end >= $today && $end <= $endCkeckedPeriod)) 
                    {
                        
                        foreach ($daterange as $periodDate) 
                        {

                            if ( $periodDate >= $today && $periodDate <= $endCkeckedPeriod) 
                            {

                                $daysCovered[] = $periodDate;

                            }
                                
                        }

                    }

                }

                $dayDate = clone $today;
                $gaps = true;

                while (in_array($dayDate, $daysCovered) && $dayDate <= $endCkeckedPeriod) 
                {

                    $dayDate->modify( '+1 day' );

                }

                if ($dayDate >= $endCkeckedPeriod) 
                {
                    
                    $gaps = false;

                }
                
                if (! $overlap && ! $previousLimit && ! $overLimit)
                {

                    $manager->persist($advert);
                    $manager->flush();  

                    if ($editMode)
                    {

                        $message = 'The periods were successfully updated.';

                    }
                    else
                    {

                        $message = 'The periods were successfully created.';

                    }

                    if($gaps)
                    {

                        $message .= ' However, there are gaps until ' . $intl_date_formatter->format($endCkeckedPeriod) . ". You will can add periods later";
                    }

                    $this->addFlash('success', $message);

                    if ($onlyPeriodsCreation) 
                     {
     
                         return $this->redirectToRoute('advert.owner');
     
                     } 
                     else 
                     {
     
                         return $this->redirectToRoute('advert.prices.create', array('id' => $advert->getId()));
     
                     }

                }

            }

        }
  
        return $this->render('advert/periods.html.twig', [
                                                            'form' => $form->createView(),
                                                            'current_menu' => $current_menu, 
                                                            'editMode' => $editMode, 
                                                            'upLimitDate' => $upLimitDate,
                                                            'seasons' => $seasons,
                                                            'locale' => $request->getLocale(),
                                                            'minimumCreationPeriods' => $this->getParameter('minimum_creation_periods'),
                                                            'bodyId' => 'advertPeriodsCreation',
                                                            'limitCreationPeriods' => $limitCreationPeriods
                                                         ]
                            )
        ;

    }

    /**
     *  @Route("/advert/prices/create/{id}/{onlyPricesCreation}", name="advert.prices.create")
     *
     * @param Advert $advert
     * @param boolean $onlyPricesCreation
     * @param DurationRepository $durationRepository
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function pricesForm(
                                    Advert $advert, bool $onlyPricesCreation = false, DurationRepository $durationRepository, 
                                    Request $request, ObjectManager $manager
                                ): Response 
    { 
        
        $editMode = false;
        
        $prices = $advert->getPrices();

        if($prices)
        {

            $editMode = true;

        }
        
        // Collection creation of seasons used in the periods 
        $seasons = new ArrayCollection();
        $sortedSeasons = new ArrayCollection();

        //Search seasons used by periods
        foreach ($advert->getPeriods() as $period) 
        {

            $season = $period->getSeason();
            
            if (! $seasons->contains($season)) 
            {
            
                $seasons->add($season);

            }

        }

        // Sort seasons by ascending cost 
        $iterator = $seasons->getIterator();

        $iterator->uasort(function ($a, $b) {

            return $a->getCost() <=> $b->getCost();

        });

        $sortedSeasons = iterator_to_array($iterator);

        // By season, search not used durations and store prices
        $missingDurations = array();

        // To filter prices by season in the template
        $idsSeasonsPrices = array();
        
        $durations = $durationRepository->findAll();
        $minimumDuration = $durationRepository->findMinimumDuration();

        foreach($sortedSeasons as $season)
        {        
                    
            $usedDurations = new ArrayCollection(); 
            
            if(! $editMode)
            {

                $price = new Price();

                $price
                    ->setSeason($season)
                    ->setDuration($minimumDuration)
                ;

                $advert->addPrice($price);
                $idsSeasonsPrices[] = $season->getId();
                $usedDurations->add($minimumDuration);

            }
            else
            {

                foreach ($prices as $price) 
                {
                    
                    if($price->getSeason() == $season)
                    {

                        $usedDurations->add($price->getDuration());

                    }

                }

            }

            foreach($durations as $duration)
            {
    
                if(! $usedDurations->contains($duration))
                {
    
                    $missingDurations[$season->getId()][] = $duration;
    
                }
    
            }

        }

        foreach($prices as $price)
        {

            $idsSeasonsPrices[] = $price->getSeason()->getId();

        }
    
        $form = $this->createForm(PricesAdvertType::class, $advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
           
            $manager->persist($advert);
            $manager->flush();  

            if ($editMode) 
            {

                $this->addFlash('success', 'Prices were successfully updated.');

            }
            else
            {

                $this->addFlash('success', 'Prices were successfully created.');

            }

            if ($onlyPricesCreation) 
            {

                return $this->redirectToRoute('advert.owner');

            } 
            else 
            {

                return $this->redirectToRoute('advert.various_costs.create', array('id' => $advert->getId()));

            }

        }
  
        return $this->render('advert/prices.html.twig', [
                                                            'form' => $form->createView(), 
                                                            'usedSeasons' => $sortedSeasons,  
                                                            'editMode' => $editMode,
                                                            'missingDurations' => $missingDurations, 
                                                            'configuredDurations' => $durations,
                                                            'bodyId' => 'advertPricesCreation',
                                                            'idsSeasonsPrices' => $idsSeasonsPrices
                                                        ]
                            )
        ;

    }

    /**
     *  @Route("/advert/various_costs/create/{id}", name="advert.various_costs.create")
     * 
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function costsForm(Advert $advert = null, Request $request, ObjectManager $manager): Response
    {

        $insurance = $advert->getInsurance();
        $prices = $advert->getPrices();
        $numberMileages = count($advert->getIncludedMileages());
        $editMode = true;

        if (
                (! $insurance) && ($numberMileages == 0) && (!$advert->getExtraKilometerCost()) && (!$advert->getIncludedCleaning()) && 
                (!$advert->getCleaningCost())
           ) 
        {

            $editMode = false;

        }

        $unique_durations = new ArrayCollection();

        if($prices)
        {
            foreach ($prices as $price) 
            {

                $duration = $price->getDuration();
                
                if(! $unique_durations->contains($duration))
                {

                    $unique_durations->add($price->getDuration());

                }

            }

        }
        
        if (! $insurance) 
        {

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
        
        $form = $this->createForm(VariousCostsType::class, array(
                                                                    'insurance' => $insurance,
                                                                    'insurancePrices' => $insurancePrices,
                                                                    'includedMileages' => $includedMileages,
                                                                    'extraKilometerCost' => $advert, 
                                                                    'cleaning' => $advert
                                                                )
                                  )
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        { 
            
            if($insurance->getIncluded())
            {

                foreach ($insurancePrices as $insurancePrice) 
                {

                    $insurance->removeInsurancePrice($insurancePrice);

                }

            }            
            
            $mileagesCorrectlyCompleted = true;
            
            foreach ($includedMileages as $includedMileage) 
            {

                if($includedMileage->getUnlimited())
                {
                    
                    $includedMileage->setMileage(null);

                }
                else
                {

                    if(! $includedMileage->getMileage())
                    {

                        $mileagesCorrectlyCompleted = false;

                    }

                }

            }

            if ($advert->getIncludedCleaning()) 
            {

                $advert->setCleaningCost(null);

            } 
            
            if($mileagesCorrectlyCompleted)
            {

            
                $manager->persist($advert);
                $manager->flush();  

                if ($editMode) 
                {

                    $this->addFlash('success', 'Costs were successfully updated.');

                }
                else
                {

                    $this->addFlash('success', 'Costs were successfully added.');

                } 

                $user = $this->getUser();

                if ($user && $user->getOwner())
                {

                    return $this->redirectToRoute('advert.subscription.create', array('id' => $advert->getId()));

                }

                return $this->redirectToRoute('user.owner.create', array('id' => $advert->getId()));

            }
            else
            {
                
                $error = new FormError("Some kilometers included are neither unlimited nor informed as to the kilometers number.");
                $form->addError($error);

            }

        }

        return $this->render('advert/variousCosts.html.twig', [
                                                                'form' => $form->createView(), 
                                                                'unique_durations' => $unique_durations, 
                                                                'insurancePrices' => $insurancePrices, 
                                                                'includedMileages' => $includedMileages, 
                                                                'idInsurancePricesDurations' => $idInsurancePricesDurations, 
                                                                'idIncludedMileagesDurations' => $idIncludedMileagesDurations, 
                                                                'bodyId' => 'advertVariousCostsCreation',
                                                                'editMode' => $insurance->getId() !== null
                                                              ]
                            )
        ;

    }

    /**
     *  @Route("/advert/subscription/create/{id}", name="advert.subscription.create")
     * 
     * @param Advert $advert
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function subscriptionForm(Advert $advert = null, ObjectManager $manager): Response
    {

        $subscriptions = $manager->getRepository(Subscription::class)->findAll(); 
        
        $vat = $manager->getRepository(VAT::class)->findOneBy(array('abbreviation' => $advert->getOwner()->getBillingAddress()->getCountry()));
        
        return $this->render('advert/subscription.html.twig', [
                                                                'advert' => $advert,
                                                                'subscriptions' => $subscriptions,
                                                                'bodyId' => 'advertSubscriptionCreation',
                                                                'vat' => $vat
                                                              ]
                            )
        ;

    }

    /**
     * @Route("/advert/subscription/set/{id}", name="advert.subscription.set", methods = "UPDATE")
     * 
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * 
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

            $this->addFlash('success', "The subscription was successfully saved.");  
            
            return $this->redirectToRoute('payment.payment', array('id' => $advert->getId()));

        }        

        $this->addFlash('error', "A technical problem occurred: the subscription type couldn't be saved.");  
            
        return $this->redirectToRoute('advert.subscription.create', array('id' => $advert->getId()));
        
    }
    
    /**
     * @Route("/advert/show/{slug}-{id}", name="advert.show", requirements = {"slug": "[a-z0-9\-]*"})
     */
    public function show(Advert $advert, String $slug, PhotoRepository $photoRepository, FavoriteRepository $favoriteRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response 
    {
        
        $user = $this->getUser();
        $receiver = $advert->getOwner()->getUser();
        $advertSlug = $advert->getSlug();
        
        if ($advertSlug !== $slug) 
        {

            return $this->redirectToRoute('all.advert.show', ['id' => $advert->getId(),
                                                              'slug' => $advertSlug
                                                             ],
                                                             301 
                                         )
            ;

        }
        
        if($user)
        {
        
            $thread = new Thread();

            $thread->setAdvert($advert)
                ->setUser($user)
                ->setOwner($advert->getOwner())
            ;        

            $mail = new Mail();

            $mail->setSender($user)
                 ->setReceiver($receiver)
                 ->setSubject($this->getParameter('contact_owner_subject'))
                 ->setThread($thread)
                 ->setBody($this->renderView(
                                                'communication/contactAboutAdvert.html.twig', 
                                                [
                                                    'mail' => $mail
                                                ]
                                            )
                          )
            ;

        }

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

        if($user)
        {

            $favorite = $favoriteRepository->findOneBy(array('advert' => $advert, 'user' => $user));
            
            $form = $this->createForm(MailType::class, $mail);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {
                
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
                                                            'favorite' => $favorite,
                                                            'bodyId' => 'advertShow',
                                                            'form' => $form->createView(),
                                                        ]
                                )
            ;

        }
        else 
        {

            return $this->render('advert/show.html.twig', [
                                                            'current_menu' => 'adverts', 
                                                            'controller_name' => 'AdvertController', 
                                                            'advert' => $advert,
                                                            'minPrice' => $minPrice,
                                                            'mainPhoto' => $mainPhoto,
                                                            'cellEquipments' => $cellEquipments,
                                                            'carrierEquipments' => $carrierEquipments,
                                                            'bodyId' => 'advertShow'
                                                          ]
                                )
            ;

        }

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
            
        return $this->redirectToRoute('advert.owner');
        
    }

    /**
     * @Route("/advert/clone/{id}", name="advert.clone")
     * @param Advert $advert
     * @param Request $request
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function clone(Advert $advert, Request $request, ObjectManager $manager): Response
    {

        $clonedAdvert = clone $advert;

        $clonedAdvert->setCreatedAt(new \DateTime('now'));
        $clonedAdvert->setExpiresAt(null);
        $clonedAdvert->setVehicle(clone $advert->getVehicle());
        $clonedAdvert->getVehicle()->setSituation(clone $advert->getVehicle()->getSituation());

        foreach ($advert->getPrices() as $price) 
        {

            $clonedAdvert->addPrice(clone $price);

        }

        foreach ($advert->getPeriods() as $period) 
        {

            $clonedAdvert->addPeriod(clone $period);

        }

        $clonedAdvert->setInsurance(clone $advert->getInsurance());

        foreach ($advert->getIncludedMileages() as $includedMileage) 
        {

            $clonedAdvert->addIncludedMileage(clone $includedMileage);

        }

        $clonedAdvert->setStripeIntentId(null);

        $manager->persist($clonedAdvert);
        $manager->flush();
            
        return $this->redirectToRoute('advert.edit', array('id' => $clonedAdvert->getId()));
        
    }

    /**
     * Get minimum advert price
     *
     * @param Advert $advert
     * @return float
     */
    private function getMinPrice(Advert $advert)
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

    /**
     * Get filtered adverts
     * 
     * @Route("/advert/ajax/filtering", options={"expose"=true}, name="advert.ajax.filtering")
     *
     * @param AdvertSearch $advertSearch
     * @param AdvertRepository $advertRepository
     * @param BookingRepository $bookingRepository
     * @param PhotoRepository $photoRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function ajaxFilteringAdverts(AdvertRepository $advertRepository, BookingRepository $bookingRepository, PhotoRepository $photoRepository, 
                                         Request $request, PaginatorInterface $paginator): JsonResponse
    {
          
            $advertSearch = $request->query->all();

            $propertyAccessor = PropertyAccess::createPropertyAccessor();

            $search = new AdvertSearch();

            foreach ($advertSearch as $key => $value) 
            {

                if($key === 'beginAt' || $key === 'endAt')
                {

                    $dateTime = new \DateTime();
                    $dateTime->createFromFormat('Y-m-d', $value);
                    $value = $dateTime;

                    if($key === 'beginAt')
                    {

                        $value->setTime('12', '0', '0');

                    }
                    else 
                    {

                        $value->setTime('11', '59', '59');

                    }

                }

                if($key === 'latitude' || $key === 'longitude')
                {

                    $value = floatval($value);

                }
                
                $propertyAccessor->setValue($search, $key, $value);

            }

            $results = array();
            $distances = array();
            
            $results = $advertRepository->findSearchedAdverts($search, $bookingRepository);

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

            $mainPhotos = array();

            if (count($adverts) > 0) 
            {
            
                $mainPhotos = $photoRepository->getMainPhotos($adverts);

            }
            
            $adverts = $paginator->paginate(
                                                $adverts, 
                                                $request->query->getInt('page', 1), 
                                                12
                                        )  
            ;
            
            $response = new JsonResponse(); 

            $response->setData(array(
                                        "code" => 200,
                                        "template" => $this->render('advert/_filteredAdverts.html.twig', [
                                                                                                            'adverts' => $adverts,
                                                                                                            'distances' => $distances,
                                                                                                            'minPrices' => $minPrices,
                                                                                                            'mainPhotos' => $mainPhotos,
                                                                                                            'userCity' => $search->getCity()
                                                                                                         ]
                                                                   )->getContent()
                                    )
                              )
            ;

        return $response;

    }

}
