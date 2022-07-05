<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RecordRepository;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'smallint')]
    private $rating;

    #[ORM\Column(type: 'text', nullable: true)]
    private $content;

    #[ORM\ManyToOne(targetEntity: Record::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private $record;

    public function __construct()
    {   
        $review = new Review;
        $this->record = Review::getRecord($review);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    static function getRecord(Review $review): Record
    {   
        $review = new Review;
        return $review->record;
    }

    public function setRecord(?Record $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function globalSetter($post, RecordRepository $recordRepository)
    {   
        $data = json_decode($post, true);
        return $this->setRating($data['rating'])
                    ->setContent($data['content'])
                    ->setRecord($recordRepository->find($data['record']));

    }
}
