<?php

namespace App\Entity\communication;

use App\Entity\user\User;
use App\Entity\user\Owner;
use App\Entity\advert\Advert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use App\Entity\communication\Mail;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\communication\ThreadRepository")
 */
class Thread
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\advert\Advert", inversedBy="threads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $advert;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\communication\Mail", mappedBy="thread", cascade={"persist"})
     * @OrderBy({"createdAt" = "ASC"})
     */
    private $mails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="threads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\Owner", inversedBy="threads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * Operations when creating
     */
    public function __construct() 
	{
        $this->createdAt = new \DateTime();
        $this->mails = new ArrayCollection();
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

        return $this->createdAt->format('d-m-Y');

    }

    /**
     * Set the creation date
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
     * Get the advert linked to this thread
     *
     * @return Advert|null
     */
    public function getAdvert(): ?Advert
    {

        return $this->advert;

    }

    /**
     * Set the advert linked to this thread
     *
     * @param Advert|null $advert
     * @return self
     */
    public function setAdvert(?Advert $advert): self
    {

        $this->advert = $advert;

        return $this;

    }

    /**
     * Get mails linked to this thread
     *
     * @return Collection|Mail[]
     */
    public function getMails(): Collection
    {

        return $this->mails;

    }

    /**
     * Add a mail to this thread
     *
     * @param Mail $mail
     * 
     * @return self
     */
    public function addMail(Mail $mail): self
    {

        if (!$this->mails->contains($mail)) 
        {

            $this->mails[] = $mail;
            $mail->setThread($this);

        }

        return $this;

    }

    /**
     * Remove a mail from this thread
     *
     * @param Mail $mail
     * @return self
     */
    public function removeMail(Mail $mail): self
    {

        if ($this->mails->contains($mail)) 
        {

            $this->mails->removeElement($mail);

            // set the owning side to null (unless already changed)
            if ($mail->getThread() === $this) 
            {

                $mail->setThread(null);

            }

        }

        return $this;

    }

    /**
     * Get the tenant
     *
     * @return User|null
     */
    public function getUser(): ?User
    {

        return $this->user;

    }

    /**
     * Set the tenant
     *
     * @param User|null $user
     * 
     * @return self
     */
    public function setUser(?User $user): self
    {

        $this->user = $user;

        return $this;

    }

    /**
     * Get the owner
     *
     * @return Owner|null
     */
    public function getOwner(): ?Owner
    {

        return $this->owner;

    }

    /**
     * Set the owner
     *
     * @param Owner|null $owner
     * 
     * @return self
     */
    public function setOwner(?Owner $owner): self
    {

        $this->owner = $owner;

        return $this;

    }

}