<?php

namespace App\Service\Model;

use App\Entity\FootballTeam;
use Symfony\Component\Serializer\Annotation\Groups;

class FootballTeamWeekStatistic
{
    /**
     * @Groups("read")
     */
    public int $total = 0;

    /**
     * @Groups("read")
     */
    public int $point = 0;

    /**
     * @Groups("read")
     */
    public int $win = 0;

    /**
     * @Groups("read")
     */
    public int $draw = 0;

    /**
     * @Groups("read")
     */
    public int $lose = 0;

    /**
     * @Groups("read")
     */
    public int $goalDifference = 0;

    public function __construct(private FootballTeam $team)
    {
    }

    public function getTeam(): FootballTeam
    {
        return $this->team;
    }

    /**
     * @Groups("read")
     */
    public function getTeamName(): string
    {
        return $this->team->getName();
    }
}
