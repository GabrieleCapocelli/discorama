<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Review;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $review = new Review();
        $review->setRating(rand(1,5));           
        $review->setContent('fuck');
        $record = $this->getReference('appetite');
        $review->setRecord($record);
        $user = $this->getReference('user1');
        $review->setUser($user);
        $manager->persist($review);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class];
    }
}
