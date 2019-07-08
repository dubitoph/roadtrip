<?php

namespace App\Entity\backend;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\VATRepository")
 * 
 * @UniqueEntity(
 *               fields={"state"},
 *               message="Ce pays existe déjà."
 * )
 */
class VAT
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30) 
     * 
     * @Assert\NotBlank(
     *      message = "Le pays ne peut pas être vide."
     * ) 
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Le pays doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "Le pays ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=5)
     *  
     * @Assert\NotBlank(
     *      message = "Le code du pays ne peut pas être vide."
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 5,
     *      minMessage = "Le code du pays doit au moins contenir {{ limit }} caractères",
     *      maxMessage = "Le code du pays ne peut dépasser {{ limit }} caractères"
     * )
     */
    private $abbreviation;

    /**
     * @ORM\Column(type="float")
     * 
     * @Assert\GreaterThan(
     *     value = 0
     * )
     * @Assert\LessThan(
     *     value = 31
     * )
     * @Assert\NotBlank(
     *      message = "Le TVA ne peut pas être vide."
     * )
     */
    private $vat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }
}
