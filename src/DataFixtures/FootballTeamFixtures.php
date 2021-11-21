<?php

namespace App\DataFixtures;

use App\Entity\FootballGroup;
use App\Entity\FootballTeam;
use App\Service\FootballGroupMatchSimulator;
use App\Service\FootballMatchSimulator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class FootballTeamFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private FootballGroupMatchSimulator $simulator)
    {
    }

    public function load(ObjectManager $manager): void
    {
        /** @var FootballGroup $group */
        $group = $this->getReference(FootballGroupFixtures::GROUP_REFERENCE_ID);

        $team1 = new FootballTeam($group, 'Super Command', 75);
        $manager->persist($team1);
        $team2 = new FootballTeam($group, 'Normal Command', 70);
        $manager->persist($team2);
        $team3 = new FootballTeam($group, 'Beginner Command', 60);
        $manager->persist($team3);
        $team4 = new FootballTeam($group, 'School Command', 50);
        $manager->persist($team4);

        $manager->flush();

        $this->simulator->process($group);
    }

    public function getDependencies(): array
    {
        return [
            FootballGroupFixtures::class,
        ];
    }
}
