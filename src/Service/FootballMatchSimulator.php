<?php

namespace App\Service;

use App\Entity\FootballMatch;
use App\Entity\FootballTeam;
use Doctrine\ORM\EntityManagerInterface;

class FootballMatchSimulator
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function simulateMatch(FootballTeam $home, FootballTeam $guest, int $week): FootballMatch
    {
        $homeResult = 0;
        $guestResult = 0;

        for ($i = 0; $i < 9; $i++) {
            $isHomeAttack = (bool)rand(0, 1);
            $successfulAttack = $isHomeAttack
                ? $this->generateAttackResult($home, $guest)
                : $this->generateAttackResult($guest, $home);

            if ($isHomeAttack && !$successfulAttack) {
                $successfulAttack = 50 > rand(0, 50);
            }

            if (!$isHomeAttack && $successfulAttack) {
                $successfulAttack = 50 > rand(0, 50);
            }

            if (!$successfulAttack) {
                continue;
            }

            if ($isHomeAttack) {
                $homeResult++;
            } else {
                $guestResult++;
            }
        }

        $match = new FootballMatch($home, $guest, $homeResult, $guestResult, $week);
        $this->em->persist($match);
        $this->em->flush();

        return $match;
    }

    private function generateAttackResult(FootballTeam $attacker, FootballTeam $defender): bool
    {
        $powerDiff = $attacker->getPower() - $defender->getPower();

        $chance = 50 + $powerDiff;

        return $chance > rand(0, 100);
    }
}
