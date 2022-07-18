<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genericCategory = new Category;
        $genericCategory->setLabel('generic');
        $manager->persist($genericCategory);
        $this->setReference('generic', $genericCategory);

        $category = new Category;
        $category->setLabel('rock');
        $manager->persist($category);
        $this->setReference('rock', $category);

        $category = new Category;
        $category->setLabel('trip-hop');
        $manager->persist($category);
        $this->setReference('trip-hop', $category);

        $manager->flush();
    }
}
