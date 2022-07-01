<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Record;

class RecordFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $record = new Record;
        $record->setTitle('Appetite for destruction');
        $record->setBand('Guns n Roses');
        $record->setDate('1987-07-21');
        $category = $this->getReference('rock');
        $record->setCategory($category);
        $manager->persist($record);
        $record = new Record;
        $record->setTitle('Mezzanine');
        $record->setBand('Massive Attack');
        $record->setDate('1998-04-20');
        $category = $this->getReference('trip-hop');
        $record->setCategory($category);
        $manager->persist($record);
        $manager->flush();

        $manager->flush();
    }
}
