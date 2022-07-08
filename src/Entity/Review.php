<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Record;
use App\Entity\User;

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

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Record::class)]
    private $record;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRecord(): ?Record
    {
        return $this->record;
    }

    public function setRecord(?Record $record): self
    {
        $this->record = $record;

        return $this;
    }

    public function globalSetter($post, RecordRepository $recordRepository, UserRepository $userRepository)
    {
        $data = json_decode($post, true);
        return $this->setRating($data['rating'])
            ->setContent($data['content'])
            ->setRecord($recordRepository->find($data['record']))
            ->setUser($userRepository->find($data['user']));
    }

    public function nullRecord(ReviewRepository $reviewRepository, Record $record)
    {
        $reviews = $reviewRepository->findBy(['record'=>$record->getId()]);
        foreach ($reviews as $review){
            $review->setRecord(NULL);
        }
    }

    public function nullUser(ReviewRepository $reviewRepository, User $user)
    {
        $reviews = $reviewRepository->findBy(['User'=>$user->getId()]);
        foreach ($reviews as $review){
            $review->setUser(NULL);
        }
    }

}
