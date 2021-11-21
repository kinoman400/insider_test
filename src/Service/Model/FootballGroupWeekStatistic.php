<?php

namespace App\Service\Model;

use App\Entity\FootballGroup;
use App\Entity\FootballMatch;
use Symfony\Component\Serializer\Annotation\Groups;

class FootballGroupWeekStatistic
{
    /**
     * @Groups("read")
     * @var FootballTeamWeekStatistic[]
     */
    public array $teams;

    /**
     * @Groups("read")
     * @var FootballMatch[]
     */
    public array $matches;

    /**
     * @Groups("read")
     * @var FootballTeamPrediction[]
     */
    public array $predictions;

    public function __construct(private FootballGroup $group, private int $week)
    {
    }

    /**
     * @Groups("read")
     */
    public function getGroupName(): string
    {
        return $this->group->getName();
    }

    /**
     * @Groups("read")
     */
    public function getWeek(): int
    {
        return $this->week;
    }
}
