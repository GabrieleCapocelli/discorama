<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Record;

class RecordFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genericRecord = new Record;
        $genericRecord->setTitle('generic');
        $genericRecord->setBand('generic');
        $genericRecord->setDate('0000-00-00');
        $category = $this->getReference('generic');
        $genericRecord->setCategory($category);
        $manager->persist($genericRecord);

        $record = new Record;
        $record->setTitle('Appetite for destruction');
        $record->setBand('Guns n Roses');
        $record->setDate('1987-07-21');
        $category = $this->getReference('rock');
        $record->setCategory($category);
        $manager->persist($record);
        $this->setReference('appetite', $record);

        $record = new Record;
        $record->setTitle('Mezzanine');
        $record->setBand('Massive Attack');
        $record->setDate('1998-04-20');
        $category = $this->getReference('trip-hop');
        $record->setCategory($category);
        $manager->persist($record);
        $this->setReference('mezzanine', $record);

        $manager->flush();
       
    }
}
