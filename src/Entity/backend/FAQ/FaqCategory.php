<?php

namespace App\Entity\backend\FAQ;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\backend\FAQ\FaqQuestion;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\FAQ\FaqCategoryRepository")
 * 
 * @UniqueEntity(
 *               fields={"category"},
 *               message="A category already exists for this category name"
 * )
 */
class FaqCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "The category must contain at least {{ limit }} characters",
     *      maxMessage = "Category can't contain more than {{ limit }} characters"
     * )
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\backend\FAQ\FaqQuestion", mappedBy="category", orphanRemoval=true)
     */
    private $faqQuestions;

    /**
     * Constructor
     */
    public function __construct()
    {

        $this->faqQuestions = new ArrayCollection();

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
     * Get the category
     *
     * @return string|null
     */
    public function getCategory(): ?string
    {

        return $this->category;

    }

    /**
     * Set the category
     *
     * @return string|null
     */
    public function setCategory(string $category): self
    {

        $this->category = $category;

        return $this;

    }

    /**
     * Get questions linked to this category
     * 
     * @return Collection|FaqQuestion[]
     */
    public function getFaqQuestions(): Collection
    {

        return $this->faqQuestions;

    }

    /**
     * Set questions linked to this category
     *
     * @param FaqQuestion $faqQuestion
     * 
     * @return self
     */
    public function addFaqQuestion(FaqQuestion $faqQuestion): self
    {

        if (!$this->faqQuestions->contains($faqQuestion)) 
        {

            $this->faqQuestions[] = $faqQuestion;
            $faqQuestion->setCategory($this);

        }

        return $this;

    }

    /**
     *  Remove a question linked to this category
     *
     * @param FaqQuestion $faqQuestion
     * 
     * @return self
     */
    public function removeFaqQuestion(FaqQuestion $faqQuestion): self
    {
        if ($this->faqQuestions->contains($faqQuestion)) 
        {

            $this->faqQuestions->removeElement($faqQuestion);

            // set the owning side to null (unless already changed)
            if ($faqQuestion->getCategory() === $this) 
            {

                $faqQuestion->setCategory(null);

            }
            
        }

        return $this;

    }

}
