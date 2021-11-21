<?php

namespace App\Service;

use App\Entity\FootballGroup;
use App\Repository\FootballMatchRepository;
use App\Service\Model\FootballGroupWeekStatistic;
use App\Service\Model\FootballTeamWeekStatistic;

class FootballGroupWeekStatisticGenerator
{
    public function __construct(
        private FootballTeamStatisticGenerator $statisticGenerator,
        private FootballMatchRepository $matchRepository,
        private FootballTeamPredictor $predictor
    ) {
    }

    public function generate(FootballGroup $group, int $week): FootballGroupWeekStatistic
    {
        $statistic = new FootballGroupWeekStatistic($group, $week);
        $this->addTeamStatistic($statistic, $group);
        $statistic->matches = $this->matchRepository->findByWeek($week);
        $this->predictor->addPredictions($statistic);

        return $statistic;
    }

    private function addTeamStatistic(FootballGroupWeekStatistic $statistic, FootballGroup $group): void
    {
        foreach ($group->getFootballTeams() as $team) {
            $statistic->teams[] = $this->statisticGenerator->generate($team, $statistic->getWeek());
        }

        $cmp = function (FootballTeamWeekStatistic $a, FootballTeamWeekStatistic $b) {
            if ($a->total === $b->total) {
                return 0;
            }

            return ($a->total > $b->total) ? -1 : 1;
        };

        $teams = &$statistic->teams;
        usort($teams, $cmp);
    }
}
