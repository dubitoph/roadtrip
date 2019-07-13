<?php

namespace App\Entity\communication;

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
     * @ORM\Column(type="text")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */
    private $message;

    /**
     * @ORM\Column(type="text")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $body;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\communication\Thread", inversedBy="mails")
     */
    private $thread;

    public function __construct() 
	{
        $this->createdAt = new \DateTime();
	}

    public function getId(): ?int
    {
        return $this->id;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

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

        $email->setFrom([$this->sender->getEmail() => $this->sender->getUserName()])
              ->setTo($this->receiver->getEmail())
              ->setBody(
                            $this->body,
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

    public function getThread(): ?Thread
    {
        return $this->thread;
    }

    public function setThread(?Thread $thread): self
    {
        $this->thread = $thread;

        return $this;
    }
}
