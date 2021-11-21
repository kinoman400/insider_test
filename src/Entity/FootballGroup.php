<?php

namespace App\Entity;

use App\Repository\FootballGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FootballGroupRepository::class)
 */
class FootballGroup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\OneToMany(targetEntity=FootballTeam::class, mappedBy="footballGroup")
     *
     * @var Collection|FootballTeam[]
     */
    private Collection $footballTeams;

    public function __construct(string $name)
    {
        $this->footballTeams = new ArrayCollection();
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|FootballTeam[]
     */
    public function getFootballTeams(): Collection
    {
        return $this->footballTeams;
    }
}
