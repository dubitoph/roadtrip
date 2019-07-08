<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\advert\Contact;

class ContactNotification
{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;
    
    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {

        $this->mailer = $mailer;
        $this->renderer = $renderer;

    }

    public function notify(Contact $contact)
    {

        $message = (new \Swift_Message('Propriétaire : ' . $contact->getAdvert()->getTitle()))
//            ->setFrom($contact->getEmail())
            ->setFrom('noryply@server.fr')
            //The following email address will must change to the owner address
            ->setTo('contact@propriétaire.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig', ['contact' => $contact]), 'text/html')
        ;

        $this->mailer->send($message);

    }

}