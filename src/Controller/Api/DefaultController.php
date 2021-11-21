<?php

namespace App\Controller\Api;

use App\Entity\FootballGroup;
use App\Repository\FootballGroupRepository;
use App\Service\FootballGroupMatchSimulator;
use App\Service\FootballGroupWeekStatisticGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class DefaultController extends AbstractController
{
    public function __construct(private FootballGroupRepository $repository)
    {
    }

    #[Route('/generate')]
    public function generate(FootballGroupMatchSimulator $generator): JsonResponse
    {
        $groups = $this->repository->findAll();
        $generator->process(reset($groups));

        return $this->json([]);
    }

    #[Route('/statistic/{week}')]
    public function statistic(
        int $week,
        FootballGroupWeekStatisticGenerator $generator,
    ): JsonResponse {
        $groups = $this->repository->findAll();

        if ($week < 1) {
            throw new BadRequestHttpException('Week should be greater/equal than 1');
        }

        $result = $generator->generate(reset($groups), $week);

        return $this->json($result, Response::HTTP_OK, [], ['groups' => ['read']]);
    }
}
