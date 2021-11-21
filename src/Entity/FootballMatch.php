<?php

namespace App\Entity;

use App\Repository\FootballMatchRepository;
use Doctrine\ORM\Mapping as ORM;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FootballMatchRepository::class)
 */
class FootballMatch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @Groups("read")
     * @ORM\ManyToOne(targetEntity=FootballTeam::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private FootballTeam $homeTeam;

    /**
     * @Groups("read")
     * @ORM\ManyToOne(targetEntity=FootballTeam::class, inversedBy="guestMatches")
     * @ORM\JoinColumn(nullable=false)
     */
    private FootballTeam $guestTeam;

    /**
     * @Groups("read")
     * @ORM\Column(type="integer")
     */
    private int $homeResult;

    /**
     * @Groups("read")
     * @ORM\Column(type="integer")
     */
    private int $guestResult;

    /**
     * @ORM\Column(type="integer")
     */
    private int $week;

    public function __construct(
        FootballTeam $homeTeam,
        FootballTeam $guestTeam,
        int $homeResult,
        int $guestResult,
        int $week
    ) {
        $this->homeTeam = $homeTeam;
        $this->guestTeam = $guestTeam;
        $this->homeResult = $homeResult;
        $this->guestResult = $guestResult;
        $this->week = $week;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHomeTeam(): ?FootballTeam
    {
        return $this->homeTeam;
    }

    public function getGuestTeam(): ?FootballTeam
    {
        return $this->guestTeam;
    }

    public function getHomeResult(): ?int
    {
        return $this->homeResult;
    }

    public function getGuestResult(): ?int
    {
        return $this->guestResult;
    }

    public function getWeek(): int
    {
        return $this->week;
    }

    public function isWinner(FootballTeam $team): bool
    {
        if ($team->getId() === $this->homeTeam->getId()) {
            return $this->homeResult > $this->guestResult;
        }

        if ($team->getId() === $this->guestTeam->getId()) {
            return $this->guestResult > $this->homeResult;
        }

        throw new InvalidArgumentException('The team is not related to this match');
    }

    public function isDraw(): bool
    {
        return $this->homeResult === $this->guestResult;
    }

    public function calculatePoints(FootballTeam $team): int
    {
        if ($this->isWinner($team)) {
            return 3;
        }

        if ($this->isDraw()) {
            return 1;
        }

        return 0;
    }

    public function calculateGoalDifference(FootballTeam $team): int
    {
        $diff = abs($this->homeResult - $this->guestResult);

        if ($this->isWinner($team)) {
            return $diff;
        }

        return -1 * $diff;
    }
}
