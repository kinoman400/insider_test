<?php

namespace App\Entity;

use App\Repository\FootballTeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FootballTeamRepository::class)
 */
class FootballTeam
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @Groups("read")
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $power;

    /**
     * @ORM\ManyToOne(targetEntity=FootballGroup::class, inversedBy="footballTeams")
     * @ORM\JoinColumn(nullable=false)
     */
    private FootballGroup $footballGroup;

    /**
     * @ORM\OneToMany(targetEntity=FootballMatch::class, mappedBy="homeTeam", orphanRemoval=true)
     *
     * @var Collection|FootballMatch[]
     */
    private Collection $homeMatches;

    /**
     * @ORM\OneToMany(targetEntity=FootballMatch::class, mappedBy="guestTeam", orphanRemoval=true)
     *
     * @var Collection|FootballMatch[]
     */
    private Collection $guestMatches;

    public function __construct(FootballGroup $footballGroup, string $name, int $power)
    {
        $this->guestMatches = new ArrayCollection();
        $this->homeMatches = new ArrayCollection();
        $this->footballGroup = $footballGroup;
        $this->name = $name;
        $this->power = $power;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function getGuestMatches(): Collection
    {
        return $this->guestMatches;
    }

    public function getHomeMatches(): Collection
    {
        return $this->homeMatches;
    }

    public function getFootballGroup(): FootballGroup
    {
        return $this->footballGroup;
    }
}
