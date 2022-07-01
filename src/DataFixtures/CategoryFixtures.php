<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categorie = new Category;
        $categorie->setLabel('rock');
        $manager->persist($categorie);
        $this->setReference('rock', $categorie);
        $categorie = new Category;
        $categorie->setLabel('trip-hop');
        $manager->persist($categorie);
        $this->setReference('trip-hop', $categorie);
        $manager->flush();
    }
}
