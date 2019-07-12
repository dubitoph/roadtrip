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
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $template;

    /**
     * @ORM\Column(type="text")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $message;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="sentMails")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $sender;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="receivedMails")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $receiver;

    /**
     * @var Advert|null
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="mails")
     */
    private $advert;

    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $subject;

    /**
     * @ORM\Column(type="datetime")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @var int|null
     * 
     * @ORM\Column(type="bigint")
     * @ORM\JoinColumn(nullable=true)
     */
    private $conversation;

    public function __construct() 
	{
        $this->createdAt = new \DateTime();
	}

    public function getId(): ?int
    {
        return $this->id;

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

    public function getConversation(): ?int
    {
        return $this->conversation;
    }

    public function setConversation(int $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }   

    public function sendEmail(\Swift_Mailer $mailer)
    {
        
        $email = (new \Swift_Message($this->subject));

        $email->setFrom([$this->sender->getEmail() => $this->sender->getUserName()])
              ->setTo($this->receiver->getEmail())
              ->setBody(
                            $this->message,
                            'text/html'
                       )
        ;

        $result = $mailer->send($email);

        return $result;

    }

    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y');

    }
}
