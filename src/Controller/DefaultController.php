<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function index()
    {
        return $this->render('base.html.twig', [
            'teams' => [
                [
                    'name' => 'test',
                    'total' => 123,
                    'point' => 12,
                    'win' => 1,
                    'draw' => 2,
                    'lose' => 3,
                    'goalDifference' => 4,
                ],
            ],
            'week' => 1,
            'matches' => [
                [
                    'homeTeam' => 'test1',
                    'guestTeam' => 'test1',
                    'homeResult' => 3,
                    'guestResult' => 2,
                ],
            ],
            'predictions' => [
                [
                    'name' => 'etrer',
                    'result' => 10,
                ],
            ]
        ]);
    }
}
