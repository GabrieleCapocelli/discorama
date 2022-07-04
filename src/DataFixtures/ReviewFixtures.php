<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Review;

class ReviewFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $review = new Review();
        $review->setRating(rand(1,5));           
        $review->setContent('fuck');
        $record = $this->getReference('appetite');
        $review->setRecord($record);
        $manager->persist($review);
        $manager->flush();
    }
}
