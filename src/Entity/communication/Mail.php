<?php

namespace App\Entity\communication;

use App\Entity\user\User;
use App\Entity\booking\Booking;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\communication\Thread;
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
     * @ORM\Column(type="text")
     * @ORM\JoinColumn(nullable=false)
     */
    private $message;

    /**
     * @ORM\Column(type="text")
     * @ORM\JoinColumn(nullable=false)
     * 
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\communication\Thread", inversedBy="mails")
     */
    private $thread;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\booking\Booking", inversedBy="mails")
     * @ORM\JoinColumn(nullable=true)
     */
    private $booking;

    /**
     * @ORM\Column(type="datetime")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isRead;

    /**
     * Operations when creating
     */
    public function __construct() 
	{

        $this->createdAt = new \DateTime();

	}

    /**
     * Get the id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Get the sender
     *
     * @return User|null
     */
    public function getSender(): ?User
    {

        return $this->sender;

    }

    /**
     * Set the sender
     *
     * @param User|null $sender
     * 
     * @return self
     */
    public function setSender(?User $sender): self
    {

        $this->sender = $sender;

        return $this;

    }

    /**
     * Get the receiver
     *
     * @return User|null
     */
    public function getReceiver(): ?User
    {

        return $this->receiver;

    }

    /**
     * Set the receiver
     *
     * @param User|null $receiver
     * 
     * @return self
     */
    public function setReceiver(?User $receiver): self
    {

        $this->receiver = $receiver;

        return $this;

    } 

    /**
     * Get the subject
     *
     * @return string|null
     */
    public function getSubject(): ?string
    {

        return $this->subject;

    }

    /**
     * Set the subject
     *
     * @param string $subject
     * 
     * @return self
     */
    public function setSubject(string $subject): self
    {

        $this->subject = $subject;

        return $this;

    }

    /**
     * Get the message
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {

        return $this->message;

    }

    /**
     * Set the message
     *
     * @param string $message
     * 
     * @return self
     */
    public function setMessage(string $message): self
    {

        $this->message = $message;

        return $this;

    }

    /**
     * Get the body
     *
     * @return string|null
     */
    public function getBody(): ?string
    {

        return $this->body;

    }

    /**
     * Set the body
     *
     * @param string $body
     * 
     * @return self
     */
    public function setBody(string $body): self
    {

        $this->body = $body;

        return $this;

    }

    /**
     * Get the thread containing this mail
     *
     * @return Thread|null
     */
    public function getThread(): ?Thread
    {

        return $this->thread;

    }

    /**
     * Set the thread containing this mail
     *
     * @param Thread|null $thread
     * @return self
     */
    public function setThread(?Thread $thread): self
    {

        $this->thread = $thread;

        return $this;

    }

    /**
     * Get the booking linked to this mail
     *
     * @return Booking|null
     */
    public function getBooking(): ?Booking
    {

        return $this->booking;

    }

    /**
     * Set the booking linked to this mail
     *
     * @param Booking|null $booking
     * 
     * @return self
     */
    public function setBooking(?Booking $booking): self
    {

        $this->booking = $booking;

        return $this;

    }

    /**
     * Get the creation date
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {

        return $this->createdAt;

    }

    /**
     * Get the formatted creation date
     *
     * @return string
     */
    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y H:m');

    }

    /**
     *  Set the creation date
     *
     * @param \DateTimeInterface $createdAt
     * 
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {

        $this->createdAt = $createdAt;

        return $this;
        
    } 

    /**
     * Get if the mail is read
     *
     * @return boolean|null
     */
    public function getIsRead(): ?bool
    {

        return $this->isRead;

    }

    /**
     * Set if the mail is read
     *
     * @param boolean $isRead
     * 
     * @return self
     */
    public function setIsRead(bool $isRead): self
    {

        $this->isRead = $isRead;

        return $this;

    }  

    /**
     * Send trhe mail
     *
     * @param \Swift_Mailer $mailer
     * 
     * @return void
     */
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

}
