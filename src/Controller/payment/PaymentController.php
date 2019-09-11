<?php

namespace App\Controller\payment;

use App\Entity\backend\VAT;
use App\Entity\payment\Bill;
use App\Entity\advert\Advert;
use App\Repository\user\UserRepository;
use App\Repository\payment\BillRepository;
use App\Repository\advert\AdvertRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;

class PaymentController extends AbstractController
{

    /**
     * @Route("/payment/payment/{id}", name="payment.payment")
     *
     * @param Advert $advert
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function payment(Advert $advert, ObjectManager $manager): Response
    {        
        
        $subscription = $advert->getSubscription();
        $amount = $subscription->getPrice();
        $vat = $manager->getRepository(VAT::class)->findOneBy(array('abbreviation' => $advert->getOwner()->getBillingAddress()->getCountry()));
        
        if ($vat) 
        {
            
            $amount = ($amount + (( $amount * ($vat->getVat() / 100) ))) * 100;

        } 

        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
        
        $intent = \Stripe\PaymentIntent::create(
                                                [
                                                    'amount' => $amount,
                                                    'currency' => 'eur',
                                                    'setup_future_usage' => 'off_session'
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
                                                            'price' => $amount / 100,
                                                            'advert' => $advert, 
                                                            'europeanCountry' => $vat !== null
                                                          ]
                            )
        ;
    }    

    /**
     * @Route("/payment/StripeFlow/{id}", name="payment.StripeFlow")
     * 
     * @return Response
     */
    public function test(Advert $advert, Request $request): Response
    {
        
        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        $owner = $advert->getOwner();
        $user = $owner->getUser();
        $billingAddress = $owner->getBillingAddress();
        $companyName = $owner->getCompanyName();

        $name = $user->getFirstname() . ' ' . $user->getName();

        if($companyName)
        {

            $name = $companyName . "\n To " . $name . "'s attention";

        }

        try
        {
            $customer = \Stripe\Customer::create(
                                                    [
                                                        'email' => $request->request->get('holder-email'),
                                                        'source'  => $request->request->get('stripeToken'),
                                                        'address' => [
                                                                        'city' => $billingAddress->getCity(),
                                                                        'country' => $billingAddress->getCountry(),
                                                                        'line1' => $billingAddress->getStreet() . ', ' . $billingAddress->getNumber(),
                                                                        'postal_code' => $billingAddress->getZipCode(),
                                                                        'state' => $billingAddress->getStreet()
                                                                     ],
                                                        'name' => $name
                                                    ]
                                                )
            ;

            $subscription = \Stripe\Subscription::create(
                                                            [
                                                                'customer' => $customer->id,
                                                                'items' => [['plan' => $advert->getSubscription()->getStripePlanId()]]
                                                            ]
                                                        )
            ;

            if ($subscription->status != 'incomplete')
            {

                $this->addFlash('success', "Your subscription was successfully created.");

            }
            else
            {

                $this->addFlash('danger', "Failed to collect initial payment for subscription. Please try again.");                
                error_log("Failed to collect initial payment for subscription");

                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId()));


            }

        }
        catch(Exception $e)
        {

            $this->addFlash('danger', "A technical error was occurred. Please try again.");
            error_log("Unable to sign up customer:" . $_POST['stripeEmail'] . ", error:" . $e->getMessage());

            return $this->redirectToRoute('payment.payment', array('id' => $advert->getId()));

        }

        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/payment/status", name="payment.status")
     */
    public function paymentStatus(AdvertRepository $advertRepository, UserRepository $userRepository, ObjectManager $manager, \Swift_Mailer $mailer)
    {  

        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));
        
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
           
        $intent = $event->data->object;
        $advert = $advertRepository->findOneBy(array('stripeIntentId' => $intent->id));
        $owner = $advert->getOwner();

        if ($event->type == "payment_intent.succeeded") 
        {
            
            //Setting the expiration date advert
            $advert->setExpiresAt(new \DateTime("now +" . $advert->getSubscription()->getDuration() . ' months'));
            
            $manager->persist($advert);
            $manager->flush();
            
            http_response_code(200);

            exit();

        } 
        elseif ($event->type == "payment_intent.payment_failed") 
        {

            $error_message = $intent->last_payment_error ? $intent->last_payment_error->message : "";

            printf("Failed: %s, %s", $intent->id, $error_message);
            http_response_code(200);

            exit();

        }        

    }

    /**
     * @Route("/payment/stripeSubscription/create", name="payment.stripeSubscription.create")
     * 
     * @return Response
     */
    public function ajaxCustomerCreation(Request $request, ObjectManager $manager)
    {
        if($request->isXmlHttpRequest())
        {
            \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

            $email = $request->request->get('email');
            $token = $request->request->get('token');
            $advertId = $request->request->get('advertId');

            $advert = $manager->getRepository(Advert::class)->find($advertId);

            $owner = $advert->getOwner();
            $user = $owner->getUser();
            $billingAddress = $owner->getBillingAddress();
            $companyName = $owner->getCompanyName();

            $name = $user->getFirstname() . ' ' . $user->getName();

            if($companyName)
            {

                $name = $companyName . "\n To " . $name . "'s attention";

            }

            $stripeCustomer = \Stripe\Customer::create(
                                                        [
                                                            'email' => $email,
                                                            'address' => [
                                                                            'city' => $billingAddress->getCity(),
                                                                            'country' => $billingAddress->getCountry(),
                                                                            'line1' => $billingAddress->getStreet() . ', ' . $billingAddress->getNumber(),
                                                                            'postal_code' => $billingAddress->getZipCode(),
                                                                            'state' => $billingAddress->getStreet()
                                                                         ],
                                                            'source' => $token,
                                                            'name' => $name
                                                        ]
                                                      )
            ;            
           
            $stripeSubscription = \Stripe\Subscription::create(
                                                                [
                                                                    'customer' => $stripeCustomer->id,
                                                                    'items' => [
                                                                                    ['plan' => $advert->getSubscription()->getStripePlanId()]
                                                                            ]
                                                                ]
                                                              )
            ;

            $advert->setStripeSubscriptionId($stripeSubscription->id);

            $manager->persist($advert);
            $manager->flush();
             
            $response = new JsonResponse();
            $response->setData(array('success'=> 'Stripe customer created.')); 

            return $response;
        }
        else
        {

            $response = new JsonResponse();
            $response->setData(array('error'=> 'Not a xmlHttpRequest'));
            return $response;
         
        }


    }

    /**
     * @Route("/payment/owner/bills", name="payment.owner.bills")
     * 
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
