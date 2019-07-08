<?php

namespace App\Entity\communication;

use App\Entity\advert\Advert;
use App\Entity\user\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\communication\MailRepository")
 */
class Mail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * 
     * @Assert\NotBlank()
     * @Assert\Regex(
     *  pattern="/[0-9]{10}/"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $emailFrom;

    /**
     * @ORM\Column(type="string", length=100)
     * 
     * @Assert\NotBlank()
     */
    private $template;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank()
     *  @Assert\Length(min=10)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="sentMails")
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="receivedMails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $receiver;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="mails")
     */
    private $advert;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $subject;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct() 
	{
        $this->createdAt = new \DateTime();
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmailFrom(): ?string
    {
        return $this->email;
    }

    public function setEmailFrom(string $emailFrom): self
    {
        $this->emailFrom = $emailFrom;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?User
    {
        return $this->receiver;
    }

    public function setReceiver(?User $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getAdvert(): ?Advert
    {
        return $this->advert;
    }

    public function setAdvert(?Advert $advert): self
    {
        $this->advert = $advert;

        return $this;
    } 

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }   

    public function sendEmail(\Swift_Mailer $mailer)
    {
        
        $email = (new \Swift_Message($this->subject));

        if(is_null($this->sender))
        {

            $email->setFrom([$this->emailFrom => $this->firstname . ' ' . $this->name]);

        }
        else
        {
            $email->setFrom([$this->sender->getEmail => $this->sender->getUserName]);

        }
                        
        $email
                ->setTo($this->receiver->getEmail())
                ->setBody(
                            $this->message,
                            'text/html'
                         )
        ;

        $result = $mailer->send($email);

        return $result;

    }
}
