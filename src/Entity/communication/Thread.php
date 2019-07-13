<?php

namespace App\Entity\communication;

use App\Entity\user\User;
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
     * @ORM\OneToMany(targetEntity="App\Entity\communication\Mail", mappedBy="thread")
     * @OrderBy({"createdAt" = "ASC"})
     */
    private $mails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user\User", inversedBy="threads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    public function __construct() 
	{
        $this->createdAt = new \DateTime();
        $this->mails = new ArrayCollection();
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getFormattedCreatedAt(): string
    {

        return $this->createdAt->format('d-m-Y');

    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    /**
     * @return Collection|Mail[]
     */
    public function getMails(): Collection
    {
        return $this->mails;
    }

    public function addMail(Mail $mail): self
    {
        if (!$this->mails->contains($mail)) {
            $this->mails[] = $mail;
            $mail->setThread($this);
        }

        return $this;
    }

    public function removeMail(Mail $mail): self
    {
        if ($this->mails->contains($mail)) {
            $this->mails->removeElement($mail);
            // set the owning side to null (unless already changed)
            if ($mail->getThread() === $this) {
                $mail->setThread(null);
            }
        }

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }
}
