<?php

namespace App\Service;

use App\Service\Model\FootballGroupWeekStatistic;
use App\Service\Model\FootballTeamPrediction;

class FootballTeamPredictor
{
    public function addPredictions(FootballGroupWeekStatistic $statistic): void
    {
        $total = 0;

        foreach ($statistic->teams as $teamStatistic) {
            $team = $teamStatistic->getTeam();
            $prediction = new FootballTeamPrediction($team);
            $prediction->prediction = $team->getPower() + $teamStatistic->total + $teamStatistic->goalDifference;
            $statistic->predictions[] = $prediction;
            $total = $total + $prediction->prediction;
        }

        foreach ($statistic->predictions as $prediction) {
            $prediction->prediction = round(($prediction->prediction * 100) / $total, 2);
        }
    }
}
