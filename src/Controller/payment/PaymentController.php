<?php

namespace App\Controller\payment;

use Exception;
use App\Entity\payment\Bill;
use App\Entity\advert\Advert;
use App\Entity\communication\Mail;
use App\Entity\user\User;
use App\Repository\user\UserRepository;
use App\Repository\backend\VATRepository;
use App\Repository\payment\BillRepository;
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
     * Collect the card data
     * 
     * @Route("/payment/payment/{id}/{chargeFailed}/{customerId}/{requiredAction}/{clientSecret}", defaults={"chargeFailed" = 0, "customerId" = 0, "requiredAction" = 0, "clientSecret" = 0}, name="payment.payment")
     *
     * @param Advert $advert
     * @param ObjectManager $manager
     * 
     * @return Response
     */
    public function payment(Advert $advert, $chargeFailed, $customerId, $requiredAction, $clientSecret, VATRepository $VATRepository, ObjectManager $manager): Response
    {        
        
        $subscription = $advert->getSubscription();
        $amount = $subscription->getPrice();
        $vat = $VATRepository->findOneBy(array('abbreviation' => $advert->getOwner()->getBillingAddress()->getCountry()));
        
        if ($vat) 
        {
            
            $amount = ($amount + (( $amount * ($vat->getVat() / 100) ))) * 100;

        } 

        return $this->render('payment/payment.html.twig', [
                                                                'stripe_account' => $this->getParameter('stripe_account'),
                                                                'stripe_public_key' => $this->getParameter('stripe_public_key'),
                                                                'stripe_betas' => $this->getParameter('stripe_betas'),
                                                                'price' => $amount / 100,
                                                                'advert' => $advert, 
                                                                'europeanCountry' => $vat !== null,
                                                                'chargeFailed' => $chargeFailed,
                                                                'customerId' => $customerId,
                                                                'requiredAction' => $requiredAction,
                                                                'clientSecret' => $clientSecret
                                                          ]
                            )
        ;

    }    

    /**
     * Create the Stripe subscription and pichk up the first payment
     * 
     * @Route("/payment/StripeFlow/{id}", name="payment.StripeFlow")
     * 
     * @return Response
     */
    public function stripeFlow(Advert $advert, VATRepository $VATRepository, UserRepository $userRepository, Request $request, ObjectManager $manager, \Swift_Mailer $mailer): Response
    {
        
        $stripeChargeFailed = $request->request->get('stripe_charge_failed');

        \Stripe\Stripe::setApiKey($this->getParameter('stripe_secret_key'));

        // The initial subscription creation
        if($stripeChargeFailed == 0)
        {

            $owner = $advert->getOwner();
            $user = $owner->getUser();
            $billingAddress = $owner->getBillingAddress();
            $companyName = $owner->getCompanyName();
            $VAT = $VATRepository->findOneBy(array('abbreviation' => $billingAddress->getCountry()));
            $paymentMethod = $request->request->get('stripe_payment_method');

            $name = $user->getFirstname() . ' ' . $user->getName();

            if($companyName)
            {

                $name = $companyName . "\n To " . $name . "'s attention";

            }

            // Create the Stripe customer
            try
            {
                $customer = \Stripe\Customer::create(
                                                        [
                                                            'address' => [
                                                                            'city' => $billingAddress->getCity(),
                                                                            'country' => $billingAddress->getCountry(),
                                                                            'line1' => $billingAddress->getStreet() . ', ' . $billingAddress->getNumber(),
                                                                            'postal_code' => $billingAddress->getZipCode(),
                                                                            'state' => $billingAddress->getState()
                                                                        ],
                                                            'name' => $name,
                                                            'payment_method' =>  $paymentMethod,
                                                            'invoice_settings' => ['default_payment_method' => $paymentMethod]
                                                        ]
                                                    )
                ;

                $owner->setStripeCustomerId($customer->id);

                $manager->persist($owner);
                $manager->flush();

            }
            catch(Exception $e)
            {

                $this->addFlash('danger', "A technical error was occurred. Please try again.");                
                error_log("Unable to create Stripe customer corresponding to owner with id : " . $owner->getId() . ", error:" . $e->getMessage());
        
                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId()));

            }

            // Create the Stripe subscription
            try
            {

                $subscription = \Stripe\Subscription::create(
                                                                [
                                                                    'customer' => $customer->id,
                                                                    'items' => [['plan' => $advert->getSubscription()->getStripePlanId()]],
                                                                    'default_tax_rates' => [$VAT->getStripeTaxRateId()],
                                                                    'off_session' => true
                                                                ]
                                                            )
                ;

                $advert->setStripeSubscriptionId($subscription->id);

                $manager->persist($owner);
                $manager->flush();

                $invoiceId = $subscription->latest_invoice;
                $invoice = \Stripe\Invoice::retrieve(['id' => $invoiceId]);
                
                $paymentIntentId = $invoice->payment_intent;
                $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

            }
            catch(Exception $e)
            {

                $this->addFlash('danger', "A technical error was occurred. Please try again.");                
                error_log("Unable to create Stripe subscription corresponding to advert with id : " . $advert->getId() . ", error:" . $e->getMessage());
        
                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId()));

            }
            
            // Stripe subscription creation response management

            // The payment is ok
            if ($subscription->status == 'active')
            {
                
                $this->succeddPaymentPostManagement($invoice, $advert, $manager, $userRepository, $user, $mailer);
       
                return $this->redirectToRoute('advert.show', array('id' => $advert->getId(), 'slug' => $advert->getSlug()));

            }
            // The method payment is refused
            elseif($paymentIntent->status == 'requires_payment_method')
            {

                $this->addFlash('danger', "The charge attempt for the subscription failed. A new payment method is required to proceed.");
                
                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId(), 'chargeFailed' => 1, 'customerId' => $customer->id));

            }
            // 3d secure ask an additional action
            elseif($paymentIntent->status == 'requires_action')
            {

                $this->addFlash('danger', "An additional securisation action is required to finalize your subscription.");

                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId(), 'requiredAction' => 1, 'clientSecret' => $paymentIntent->client_secret));

            }           
            
        }
        // Resend form management
        else
        {

            // Update the Stripe customer with the new ayment method
            try
            {

                $stripeCustomerId = $request->request->get('stripe_customer_id');
                
                \Stripe\Customer::update(
                                            $stripeCustomerId,
                                            [
                                                'payment_method' =>  $paymentMethod,
                                                'invoice_settings' => ['default_payment_method' => $paymentMethod]
                                            ]
                                        )
                ;
            }
            catch(Exception $e)
            {

                $this->addFlash('danger', "A technical error was occurred. Please try again.");                
                error_log("Unable to update Stripe customer with Stripe id : " . $stripeCustomerId . " and owner id " . $owner->getId() . ", error:" . $e->getMessage());
        
                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId(), 'chargeFailed' => 1, 'customerId' => $customer->id));

            }            

            // Reattempt the payment
            $invoice = \Stripe\Invoice::retrieve(['id' => $subscription->latest_invoice->payment_intent->id]);
            $invoice->pay();

            // The payment is ok
            if ($paymentIntent->status == 'succeeded')
            {
                
                $this->succeddPaymentPostManagement($invoice, $advert, $manager, $userRepository, $user, $mailer);
        
                return $this->redirectToRoute('advert.show', array('id' => $advert->getId(), 'slug' => $advert->getSlug()));

            }
            // The payment method is refused
            elseif($paymentIntent->status == 'requires_payment_method')
            {

                $this->addFlash('danger', "The charge attempt for the subscription failed. A new payment method is required to proceed.");
                
                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId(), 'chargeFailed' => 1, 'customerId' => $customer->id));

            }
            // 3d secure ask an additional action
            elseif($paymentIntent->status == 'requires_action')
            {

                $this->addFlash('danger', "An additional securisation action is required to finalize your subscription.");

                return $this->redirectToRoute('payment.payment', array('id' => $advert->getId(), 'requiredAction' => 1, 'clientSecret' => $paymentIntent->client_secret));
                
            }

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

    /**
     * Post succeed subscription payment management
     *
     * @param \Stripe\Subscription $invoice
     * @param Advert $advert
     * @param ObjectManager $manager
     * @param UserRepository $userRepository
     * @param User $user
     * @param \Swift_Mailer $mailer
     * 
     * @return void
     */
    public function succeddPaymentPostManagement($invoice, $advert, $manager, $userRepository, $user, $mailer)
    {
                
        $this->addFlash('success', "Your subscription was successfully created.");

        // Create the bill in the database
        $bill = new Bill();

        $bill->setStripeUrl($invoice->invoice_pdf)
             ->setAdvert($advert)
        ;

        $manager->persist($bill);
        $manager->flush();

        // Send an email to the user
        $mail = new Mail;

        $administrator = $userRepository->findOneBy(array('name' => 'administrator'));

        $mail->setReceiver($user)
             ->setSubject($this->getParameter('new_subscription_subject'))
             ->setSender($administrator)
             ->setMessage('Your subscription on Roadtripr')
             ->setBody($this->renderView(
                                            'communication/newSubscription.html.twig', 
                                            ['mail' => $mail]
                                        )
                      )
        ;

        if ($mail->sendEmail($mailer))
        {                

            $manager->persist($mail);
            $manager->flush();

        }

    }

}