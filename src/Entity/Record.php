<?php

namespace App\Entity;

use App\Repository\RecordRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

#[ORM\Entity(repositoryClass: RecordRepository::class)]
class Record
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    /**
     * @Assert\NotBlank(message="Please provide a title")
     * @Assert\Length(
     *     min=1,
     *     max=100,
     *     minMessage="The name must be at least 3 characters long",
     *     maxMessage="The name cannot be longer than 100 characters"
     * )
     */

    #[ORM\Column(type: 'string', length: 100)]
    private $title;
        /**
     * @Assert\NotBlank(message="Please provide a title")
     * @Assert\Length(
     *     min=1,
     *     max=100,
     *     minMessage="The name must be at least 3 characters long",
     *     maxMessage="The name cannot be longer than 100 characters"
     * )
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $band;
    
   
    #[ORM\Column(type: 'date')]
    private $date;

    #[ORM\ManyToOne(targetEntity: Category::class, fetch:"EAGER")]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBand(): ?string
    {
        return $this->band;
    }

    public function setBand(string $band): self
    {
        $this->band = $band;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = new DateTime($date);
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
