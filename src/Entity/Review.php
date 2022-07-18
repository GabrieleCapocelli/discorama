<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use App\Repository\RecordRepository;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    public $id;

    /**
     * @Assert\Range(
     *     min=1,
     *     max=5
     * )
     */
    #[ORM\Column(type: 'smallint')]
    public $rating;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=3,
     *     max=10000
     * )
     */
    #[ORM\Column(type: 'text', nullable: true)]
    public $content;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy:'reviews')]
    public $user;

    #[ORM\ManyToOne(targetEntity: Record::class, inversedBy: 'reviews')]
    public $record;

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

    public function genericRecord(ReviewRepository $reviewRepository, Record $record, RecordRepository $recordRepository)
    {
        $reviews = $reviewRepository->findBy(['record'=>$record->getId()]);
        foreach ($reviews as $review){
            $review->setRecord($recordRepository->findOneBy(['id'=>1]));
        }
    }

    public function anonymizeUser(ReviewRepository $reviewRepository, User $user, UserRepository $userRepository)
    {
        $reviews = $reviewRepository->findBy(['user'=>$user->getId()]);
        foreach ($reviews as $review){
            $review->setUser($userRepository->findOneBy(['id'=>1]));
        }
    }

}
