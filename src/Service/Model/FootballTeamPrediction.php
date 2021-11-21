<?php

namespace App\Service\Model;

use App\Entity\FootballTeam;
use Symfony\Component\Serializer\Annotation\Groups;

class FootballTeamPrediction
{
    /**
     * @Groups("read")
     */
    public float $prediction = 0;

    public function __construct(private FootballTeam $team)
    {
    }

    /**
     * @Groups("read")
     */
    public function getName(): string
    {
        return $this->team->getName();
    }
}
