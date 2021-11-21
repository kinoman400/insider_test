<?php

namespace App\Service;

use App\Entity\FootballGroup;
use App\Entity\FootballTeam;
use App\Repository\FootballMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class FootballGroupMatchSimulator
{
    public function __construct(
        private EntityManagerInterface $em,
        private FootballMatchRepository $matchRepository,
        private FootballMatchSimulator $matchGenerator
    ) {
    }

    public function process(FootballGroup $group)
    {
        $this->clearExistedMatches();

        $teams = $group->getFootballTeams();

        foreach ($teams as $team) {
            $this->createHomeMatches($team);
        }
    }

    private function clearExistedMatches(): void
    {
        foreach ($this->matchRepository->findAll() as $match) {
            $this->em->remove($match);
        }

        $this->em->flush();
    }

    private function createHomeMatches(FootballTeam $team)
    {
        $teams = $team->getFootballGroup()
            ->getFootballTeams()
            ->filter(fn(FootballTeam $t) => $t->getId() !== $team->getId());


        foreach ($teams as $guest) {
            $week = $this->findAvailableWeek($team, $guest);

            $this->matchGenerator->simulateMatch($team, $guest, $week);
        }
    }

    protected function findAvailableWeek(FootballTeam $home, FootballTeam $guest): int
    {
        $week = 1;

        while (true) {
            $hasMatches = $this->matchRepository->hasMatches([$home, $guest], $week);

            if ($hasMatches) {
                $week++;
                continue;
            }

            $totalMatches = count($this->matchRepository->findByWeek($week));

            if ($totalMatches === 2) {
                $week++;
                continue;
            }

            break;
        }

        return $week;
    }
}
