<?php

namespace App\Service;

use App\Entity\FootballTeam;
use App\Repository\FootballMatchRepository;
use App\Service\Model\FootballTeamWeekStatistic;

class FootballTeamStatisticGenerator
{
    public function __construct(private FootballMatchRepository $matchRepository)
    {
    }

    public function generate(FootballTeam $team, int $week): FootballTeamWeekStatistic
    {
        $matches = $this->matchRepository->findMatchesByWeekRange($team, 1, $week + 1);

        $statistic = new FootballTeamWeekStatistic($team);

        foreach ($matches as $match) {
            $points = $match->calculatePoints($team);

            if ($match->getWeek() === $week) {
                $statistic->point = $points;
            }

            $statistic->total = $statistic->total + $points;

            if ($match->isWinner($team)) {
                $statistic->win++;
            } elseif ($match->isDraw()) {
                $statistic->draw++;
            } else {
                $statistic->lose++;
            }

            $statistic->goalDifference = $statistic->goalDifference + $match->calculateGoalDifference($team);
        }

        return $statistic;
    }
}
