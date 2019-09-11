<?php

namespace App\Controller\backend;

use App\Entity\backend\Subscription;
use App\Form\backend\SubscriptionType;
use App\Repository\backend\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendSubscriptionController extends AbstractController
{
    
    /**
     * @Route("/backend/subscriptions", name="backend.subscription.index")
     * @param SubscriptionRepository $subscriptionRepository
     * @return Response
     */
    public function index(SubscriptionRepository $subscriptionRepository): Response
    {
     
        $subscriptions = $subscriptionRepository->findAll();
    
        return $this->render('backend/subscription/index.html.twig', compact('subscriptions'));  
        
    }

    /**
     * @Route("/backend/subscription/create", name="backend.subscription.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager): Response
    {

        $subscription = new Subscription;

        $form = $this->createForm(SubscriptionType::class, $subscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            // Create Stripe product to use it in the Stripe subscription
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
            
            $stripeProduct = \Stripe\Product::create(
                                                        [
                                                            "name" => $subscription->getTitle(),
                                                            "type" => "service",
                                                            "active" => $subscription->getIsActive()
                                                        ]
                                                    )
            ;
            
            $subscription->setStripeProductId($stripeProduct->id);

            // Create Stripe plan linked to the Stripe product
            $stripePlan = \Stripe\Plan::create
                                                (
                                                    [
                                                        'currency' => 'eur',
                                                        'interval' => 'month',
                                                        'interval_count' => $subscription->getDuration(),
                                                        'product' => $stripeProduct->id,
                                                        'nickname' => $subscription->getTitle() . ' plan',
                                                        'amount' => $subscription->getPrice() * 100
                                                    ]
                                                )
            ;

            $subscription->setStripePlanId($stripePlan->id);

            $manager->persist($subscription);
            $manager->flush(); 

            $this->addFlash('success', "The subscription was successfully created.");      

            return $this->redirectToRoute('backend.subscription.index');
        }
     
        return $this->render('backend/subscription/new.html.twig', [
                                                                        'subscription' => $subscription,
                                                                        'form' => $form->createView(),
                                                                   ]
                            )
        ;        
    }

    /**
     * @Route("/backend/subscription/edit/{id}", name="backend.subscription.edit")
     * @param Subscription $subscription
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Subscription $subscription, Request $request, ObjectManager $manager): Response
    {

        $oldSubscription = clone $subscription;
        
        $form = $this->createForm(SubscriptionType::class, $subscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {

            // Update the Stripe product to use it in the Stripe subscription
            $subscriptionTitle = $subscription->getTitle();
            $oldSubscriptionTitle = $oldSubscription->getTitle();
            $subscriptionActive = $subscription->getIsActive();
            $oldSubscriptionActive = $oldSubscription->getIsActive();

            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

            if(($subscriptionTitle !== $oldSubscriptionTitle) || ($subscriptionActive !== $oldSubscriptionActive))
            {
                
                \Stripe\Product::update(
                                            $subscription->getStripeProductId(),
                                            [
                                                "name" => $subscriptionTitle,
                                                "active" => $subscriptionActive
                                            ]
                                       )
                ;
            }

            // Update Stripe plan linked to the Stripe product
            $subscriptionDuration = $subscription->getDuration();
            $oldSubscriptionDuration = $oldSubscription->getDuration();
            $subscriptionPrice = $subscription->getPrice();
            $pldSubscriptionPrice = $oldSubscription->getPrice();
            $stripePlanId = $subscription->getStripePlanId();

            if(($subscriptionDuration !== $oldSubscriptionDuration) || ($subscriptionPrice !== $pldSubscriptionPrice))
            {

                // Create a new Stripe plan linked to the Stripe product
                $oldStripePlan = \Stripe\Plan::retrieve($stripePlanId);
                $oldStripePlan->delete();
                
                $stripePlan = \Stripe\Plan::create(
                                                        [
                                                            'currency' => 'eur',
                                                            'interval' => 'month',
                                                            'interval_count' => $subscription->getDuration(),
                                                            'product' => $subscription->getStripeProductId(),
                                                            'nickname' => $subscription->getTitle() . ' plan',
                                                            'amount' => $subscription->getPrice() * 100
                                                        ]
                                                  )
                ;

                $subscription->setStripePlanId($stripePlan->id);

            }
            elseif($subscriptionTitle !== $oldSubscriptionTitle)
            {

                \Stripe\Plan::update
                                    (
                                        $subscription->getStripePlanId(),
                                        [
                                            'nickname' => $subscription->getTitle() . ' plan',
                                        ]
                                    )
                ;  

            }       

            $manager->persist($subscription);
            $manager->flush();

            $this->addFlash('success', "The subscription was successfully updated.");                   

            return $this->redirectToRoute('backend.subscription.index');
        }
     
        return $this->render('backend/subscription/edit.html.twig', [
                                                                        'subscription' => $subscription,
                                                                        'form' => $form->createView(),
                                                                    ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/subscription/delete/{id}", name="backend.subscription.delete", methods = "DELETE")
     * @param Subscription $subscription
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Subscription $subscription, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $subscription->getId(), $request->get('_token'))) 
        {

            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
            
            $stripeProductId = $subscription->getStripeProductId();
            $stripePlanId = $subscription->getStripePlanId();

            $stripePlan = \Stripe\Plan::retrieve($stripePlanId);
            $stripePlan->delete();
            
            $stripeProduct = \Stripe\Product::retrieve($stripeProductId);
            $stripeProduct->delete();

            $manager->remove($subscription);
            $manager->flush();

            $this->addFlash('success', "The subscription was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.subscription.index');
        
    }
}