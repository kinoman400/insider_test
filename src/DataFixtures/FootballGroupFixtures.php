<?php

namespace App\DataFixtures;

use App\Entity\FootballGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FootballGroupFixtures extends Fixture
{
    public const GROUP_REFERENCE_ID = 'group';

    public function load(ObjectManager $manager): void
    {
        $group = new FootballGroup('A');
        $manager->persist($group);
        $manager->flush();

        $this->addReference(self::GROUP_REFERENCE_ID, $group);
    }
}
