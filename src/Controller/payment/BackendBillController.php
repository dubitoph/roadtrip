<?php

namespace App\Controller\payment;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\backend\VAT;
use App\Entity\advert\Advert;
use App\Repository\payment\BillRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\payment\Bill;

class BackendBillController extends AbstractController
{
    
    /**
     * @Route("/backend/bills", name="backend.bill.index")
     * @param BillRepository $billRepository
     * @return Response
     */
    public function index(BillRepository $billRepository): Response
    {
     
        $bills = $billRepository->findAll();
    
        return $this->render('backend/bill/index.html.twig', compact('bills'));  
        
    }

    /**
     * @Route("/backend/bill/create/{id}", name="backend.bill.create")
     * @param Request $request
     * @param ObjectManager $manager
     */
    public function new(Advert $advert, Request $request, ObjectManager $manager)
    {
        
        $subscription = $advert->getSubscription();
        $excludingTaxesAmount = $subscription->getPrice();
        $vat = $manager->getRepository(VAT::class)->findOneBy(array('abbreviation' => $advert->getOwner()->getBillingAddress()->getCountry()));
        $includingTaxesAmount = null;
        
        if ($vat) 
        {
            
            $vatAmount = ( $excludingTaxesAmount * $vat->getVat() ) / 100;
            $includingTaxesAmount = $excludingTaxesAmount + $vatAmount;

        }
        
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');
        
        $dompdf = new Dompdf($pdfOptions);
        
        $html = $this->renderView('backend/Bill//bill.html.twig', [
                                                                    'subscription' => $subscription,
                                                                    'advert' => $advert,
                                                                    'vat' => $vat,
                                                                    'vatAmount' => $vatAmount,
                                                                    'includingTaxesAmount' => $includingTaxesAmount
                                                                  ]
                                 )
        ;
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $directory = $this->getParameter('bills_directory') . '/' . date('Y') . '/' . date('m') . '/' .  $advert->getOwner()->getId();

        if(! is_dir($directory))
        {

            if (! mkdir($directory, 0777, true)) 
            {

                die('Failed to create the directory');

            }

        }

        $output = $dompdf->output();

        $fileName = date("Y-m-d-H-i-s") . '_' . $advert->getId() . '.pdf';

        $pdfFilepath =  $directory . '/' . $fileName ;

        file_put_contents($pdfFilepath, $output);

        $bill = new Bill();

        $bill->setName($fileName)
             ->setAdvert($advert)
        ;           

        $manager->persist($bill);
        $manager->flush();   

        return new Response('OK');

    }

}