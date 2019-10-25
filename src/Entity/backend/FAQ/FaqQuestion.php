<?php

namespace App\Entity\backend\FAQ;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use App\Entity\backend\FAQ\FaqCategory;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\backend\FAQ\FaqQuestionRepository")
 * 
 * @UniqueEntity(
 *               fields={"question"},
 *               message="This question already exists"
 * )
 */
class FaqQuestion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(
     *      min = 10,
     *      max = 255,
     *      minMessage = "The question must contain at least {{ limit }} characters",
     *      maxMessage = "Question can't contain more than {{ limit }} characters"
     * )
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "The answer must contain at least {{ limit }} characters"
     * )
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\backend\FAQ\FaqCategory", inversedBy="faqQuestions")
     * @ORM\JoinColumn(nullable=false)
     * @OrderBy({"category" = "DESC"})
     */
    private $category;

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
     * Get the question
     *
     * @return string|null
     */
    public function getQuestion(): ?string
    {

        return $this->question;

    }

    /**
     * Set the question
     *
     * @param string $question
     * 
     * @return self
     */
    public function setQuestion(string $question): self
    {

        $this->question = $question;

        return $this;

    }

    /**
     * Get the answer
     *
     * @return string|null
     */
    public function getAnswer(): ?string
    {

        return $this->answer;

    }

    /**
     * Set the answer
     *
     * @param string $answer
     * 
     * @return self
     */
    public function setAnswer(string $answer): self
    {

        $this->answer = $answer;

        return $this;

    }

    /**
     * Get the category
     *
     * @return FaqCategory|null
     */
    public function getCategory(): ?FaqCategory
    {

        return $this->category;

    }

    /**
     * Set the category
     *
     * @param FaqCategory|null $category
     * 
     * @return self
     */
    public function setCategory(?FaqCategory $category): self
    {

        $this->category = $category;

        return $this;

    }

}
