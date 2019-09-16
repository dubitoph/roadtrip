<?php

namespace App\Controller\backend;

use App\Entity\backend\VAT;
use App\Form\backend\VATType;
use App\Repository\backend\VATRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackendVATController extends AbstractController
{
    
    /**
     * @Route("/backend/VAT_All", name="backend.VAT.index")
     * @param VATRepository $VATRepository
     * @return Response
     */
    public function index(VATRepository $VATRepository): Response
    {
     
        $allVAT = $VATRepository->findAll();
    
        return $this->render('backend/VAT/index.html.twig', compact('allVAT'));  
        
    }

    /**
     * @Route("/backend/VAT/create", name="backend.VAT.create")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function new(Request $request, ObjectManager $manager, TranslatorInterface $translator): Response
    {

        $VAT = new VAT;

        $form = $this->createForm(VATType::class, $VAT);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {   
            
            // Create Stripe VAT
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));            

            try
            {

                $tax_rate = \Stripe\TaxRate::create(
                                                        [
                                                            'display_name' => 'VAT',
                                                            'description' => 'VAT ' . $VAT->getState(),
                                                            'jurisdiction' => $VAT->getAbbreviation(),
                                                            'percentage' => $VAT->getVat(),
                                                            'inclusive' => false
                                                        ]
                                                   )
                ;
                
                $VAT->setStripeTaxRateId($tax_rate->id);
            
                $manager->persist($VAT);
                $manager->flush();

                $this->addFlash('success', "The VAT was successfully created.");      
    
                return $this->redirectToRoute('backend.VAT.index');

            }
            catch(Exception $e)
            {

                $this->addFlash('danger', "A technical error was occurredduring the Stripe TaxRate creation.");
                error_log("Unable to create the " . $VAT->getState() . " Stripe. Error:" . $e->getMessage());

                exit();

            }
        }
     
        return $this->render('backend/VAT/new.html.twig', [
                                                                'VAT' => $VAT,
                                                                'form' => $form->createView(),
                                                               ]
                            )
        ;        
    }

    /**
     * @Route("/backend/VAT/{id}", name="backend.VAT.edit")
     * @param VAT $VAT
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(VAT $VAT, Request $request, ObjectManager $manager): Response
    {

        $oldVAT = $VAT->getVat();
        $oldState = $VAT->getState();
        $oldAbbreviation = $VAT->getAbbreviation();

        $error = false;
        
        $form = $this->createForm(VATType::class, $VAT);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            // Update the Stripe VAT
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

            try
            {
    
                // Create new Stripe tax rate
                $tax_rate = \Stripe\TaxRate::create(
                                                        [
                                                            'display_name' => 'VAT',
                                                            'description' => 'VAT ' . $VAT->getState(),
                                                            'jurisdiction' => $VAT->getAbbreviation(),
                                                            'percentage' => $VAT->getVat(),
                                                            'inclusive' => false
                                                        ]
                                                   )
                ;
                    
                $VAT->setStripeTaxRateId($tax_rate->id);

            }
            catch(Exception $e)
            {
    
                $this->addFlash('danger', "A technical error was occurredduring the Stripe TaxRate creation.");
                error_log("Unable to create the " . $VAT->getState() . " Stripe. Error:" . $e->getMessage());
                $error = true;
    
            }

            if(! $error)
            {

                $manager->persist($VAT);
                $manager->flush();
                
                $this->addFlash('success', "The VAT was successfully updated.");
                
            }

            return $this->redirectToRoute('backend.VAT.index');
        }
     
        return $this->render('backend/VAT/edit.html.twig', [
                                                                    'VAT' => $VAT,
                                                                    'form' => $form->createView(),
                                                                ]
                            )
        ;  
        
    }

    /**
     * @Route("/backend/VAT/delete/{id}", name="backend.VAT.delete", methods = "DELETE")
     * @param VAT $VAT
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(VAT $VAT, Request $request, ObjectManager $manager): Response
    {

        if ($this->isCsrfTokenValid('delete'. $VAT->getId(), $request->get('_token'))) 
        {
            
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

            try
            {
    
                // Remove the Stripe VAT
                $tax_rate = \Stripe\TaxRate::retrieve($VAT->getStripeTaxRateId());
                $tax_rate->delete();

            }
            catch(Exception $e)
            {
    
                $this->addFlash('danger', "A technical error was occurredduring the Stripe TaxRate remove.");
                error_log("Unable to remove the Stripe tax rate with id " . $tax_rate->id . ". Error:" . $e->getMessage());
                $error = true;
    
            }

            $manager->remove($VAT);
            $manager->flush();

            $this->addFlash('success', "VAT was successfully removed."); 

        } 
            
         return $this->redirectToRoute('backend.VAT.index');
        
    }
}