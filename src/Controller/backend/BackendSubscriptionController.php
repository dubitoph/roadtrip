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

        if ($form->isSubmitted() && $form->isValid()) {            

            $manager->persist($subscription);
            $manager->flush();    

            $this->addFlash('success', "L'abonnement a été créé avec succès.");      

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

        $form = $this->createForm(SubscriptionType::class, $subscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {           

            $manager->flush();

            $this->addFlash('success', "L'abonnement a été modifié avec succès.");                   

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

        if ($this->isCsrfTokenValid('delete'. $subscription->getId(), $request->get('_token'))) {

            $manager->remove($subscription);
            $manager->flush();

            $this->addFlash('success', "L'abonnement a été supprimé avec succès."); 

        } 
            
         return $this->redirectToRoute('backend.subscription.index');
        
    }
}