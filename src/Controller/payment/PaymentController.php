<?php

namespace App\Controller\payment;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\backend\VAT;
use App\Entity\payment\Bill;
use App\Entity\advert\Advert;
use App\Entity\communication\Mail;
use App\Repository\payment\BillRepository;
use App\Repository\advert\AdvertRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;

class PaymentController extends AbstractController
{

    /**
     * @Route("/payment/payment/{id}", name="payment.payment")
     * @return Response
     */
    public function payment(Advert $advert, Request $request, ObjectManager $manager): Response
    {        
        
        $amount = $advert->getSubscription()->getPrice();
        $vat = $manager->getRepository(VAT::class)->findOneBy(array('abbreviation' => $advert->getOwner()->getBillingAddress()->getCountry()));
        
        if ($vat) 
        {
            
            $amount = ($amount + ( ( $amount * $vat->getVat() ) / 100 )) * 100;

        }


        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $intent = \Stripe\PaymentIntent::create(
                                                [
                                                    'amount' => $amount,
                                                    'currency' => 'eur',
                                                ]
                                               )
        ;

        $advert->setStripeIntentId($intent->id);

        $manager->persist($advert);
        $manager->flush();

        return $this->render('payment/payment.html.twig', [
                                                            'stripe_account' => $this->getParameter('stripe_account'),
                                                            'stripe_public_key' => $this->getParameter('stripe_public_key'),
                                                            'stripe_betas' => $this->getParameter('stripe_betas'),
                                                            'intent' => $intent,
                                                            'advert' => $advert, 
                                                            'europeanCountry' => $vat !== null
                                                          ]
                            )
        ;
    }

    /**
     * @Route("/payment/status", name="payment.status")
     */
    public function paymentStatus(AdvertRepository $advertRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer)
    {  

        $endpoint_secret = $this->getParameter('stripe_endpoint_secret');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try 
        {

            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

        } 
        catch(\UnexpectedValueException $e) 
        {

            // Invalid payload
            http_response_code(400);
            exit();
        } 
        
        catch(\Stripe\Error\SignatureVerification $e) 
        {

            // Invalid signature
            http_response_code(400);
            exit();

        }

        if ($event->type == "payment_intent.succeeded") 
        {

            $intent = $event->data->object;
            
            //Setting the expiration date advert 
            $advert = $advertRepository->findOneBy(array('stripeIntentId' => $intent->id));

            $advert->setExpiresAt(new \DateTime("now +" . $advert->getSubscription()->getDuration() . ' months'));
            
            $manager->persist($advert);
            $manager->flush(); 

            //Bill generation 
//            return $this->redirectToRoute('backend.bill.create', array('id' => $advert->getId()));

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
            
            //Sending an email confirmation about the success payment
            $mail = new Mail;

            $user = $advert->getOwner()->getUser();

            $mail->setReceiver($user)
                 ->setSender(null)
                 ->setSubject($this->getParameter('succeed_payment_email_subject'))
                 ->setFirstname($this->getParameter('administrateur_firstname'))
                 ->setName($this->getParameter('administrateur_name'))
                 ->setEmailFrom($this->getParameter('administrateur_email'))
                 ->setTemplate('communication/succeedPaymentEmail.html.twig')
                 ->setMessage($this->renderView(
                                                $mail->getTemplate(), 
                                                ['user' => $user]
                                               )
                             )
            ;

            if ($mail->sendEmail($mailer))
            {                

                $manager->persist($mail);
                $manager->flush();

            }
            
            http_response_code(200);

            exit();

        } 
        elseif ($event->type == "payment_intent.payment_failed") 
        {

            $intent = $event->data->object;
            $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";
            printf("Failed: %s, %s", $intent->id, $error_message);
            http_response_code(200);
            exit();

        }        

    }

    /**
     * @Route("/payment/owner/bills", name="payment.owner.bills")
     * @return Response
     */
    public function ownerBills(BillRepository $billRepository): Response
    {

        $bills = $billRepository->findOwnerBills($this->getUser()->getOwner()->getAdverts());
     
        return $this->render('payment/ownerBills.html.twig', ['bills' => $bills]);

    }

    /**
     * @Route("/payment/bill/show/{id}", name="payment.bill.show")
     * @return Response
     */
    public function show(Bill $bill): Response
    {

        $fileName = $bill->getName();
        
        $billFile = $directory = $this->getParameter('bills_directory') . '/' . substr($fileName, 0, 4) . '/' . substr($fileName, 5, 2) . '/' . 
                    $bill->getAdvert()->getOwner()->getId() . '/' . $bill->getName(); 
     
        return new BinaryFileResponse($billFile);

    }

    /**
     * @Route("/payment/bill/download/{id}", name="payment.bill.download")
     * @return Response
     */
    public function download(Bill $bill): Response
    {

        $fileName = $bill->getName();
        
        $billFile = $directory = $this->getParameter('bills_directory') . '/' . substr($fileName, 0, 4) . '/' . substr($fileName, 5, 2) . '/' . 
                    $bill->getAdvert()->getOwner()->getId() . '/' . $bill->getName(); 
     
        $response = new BinaryFileResponse($billFile);

        $mimeTypeGuesser = new FileinfoMimeTypeGuesser();

        if($mimeTypeGuesser->isSupported())
        {
            $response->headers->set('Content-Type', $mimeTypeGuesser->guess($billFile));

        }
        else
        {
            $response->headers->set('Content-Type', 'text/plain');

        }

        $response->setContentDisposition(
                                            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                                            $bill->getName()
                                        )
        ;

        return $response;

    }

}
