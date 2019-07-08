<?php

namespace App\Entity\advert;

use App\Entity\advert\Advert;
use Symfony\Component\Validator\Constraints as Assert;

class Contact
{

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $firstName;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $lastName;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     *  pattern="/[0-9]{10}/"
     * )
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     *  @Assert\Length(min=10)
     */
    private $message;

    /**
     * @var Advert|null
     */
    private $advert;

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {

        return $this->firstName;

    }

    /**
     * @return null|string
     */
    public function setFirstName(?string $firstName): Contact
    {

        $this->firstName = $firstName;
        return $this;

    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {

        return $this->lastName;

    }

    /**
     * @return null|string
     */
    public function setLastName(?string $lastName): Contact
    {

        $this->lastName = $lastName;
        return $this;

    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {

        return $this->phone;

    }

    /**
     * @return null|string
     */
    public function setPhone(?string $phone): Contact
    {

        $this->phone = $phone;
        return $this;

    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {

        return $this->email;

    }

    /**
     * @return null|string
     */
    public function setEmail(?string $email): Contact
    {

        $this->email = $email;
        return $this;

    }

    /**
     * @return null|string
     */
    public function getMessage(): ?string
    {

        return $this->message;

    }

    /**
     * @return null|string
     */
    public function setMessage(?string $message): Contact
    {

        $this->message = $message;
        return $this;

    }

    /**
     * @return null|Advert
     */
    public function getAdvert(): ?Advert
    {

        return $this->advert;

    }

    /**
     * @return null|Advert
     */
    public function setAdvert(?Advert $advert): Contact
    {

        $this->advert = $advert;
        return $this;

    }

}