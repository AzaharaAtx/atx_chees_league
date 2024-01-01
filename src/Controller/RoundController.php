<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\League;
use App\Entity\LeaguePlayer;
use App\Entity\Round;
use App\Services\ChessRounds;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RoundController extends AbstractController
{
    public function __construct (EntityManagerInterface $em, ManagerRegistry $doctrine)
    {
        $this->em = $em;
        $this->doctrine = $doctrine;

    }
    #[Route('api/round/show/players/leagues', name: 'app_league_participants', methods: ['GET'])]
    public function show(Request $request): Response
    {
        $league_player = $this->doctrine
            ->getRepository(LeaguePlayer::class)
            ->findAllParticipants();

        return $this->json([
            'message' => 'League list recover',
            'data' => $league_player],
            200);
    }
    #[Route('api/league/round/create/{id}', name: 'app_league_round_create', methods: ['POST'])]
    public function create(int $id, SerializerInterface $serializer, ChessRounds $chessRounds): JsonResponse
    {
        $doctrine = $this->doctrine->getManager();
        $em = $this->em;

        $league = $doctrine->getRepository(League::class)->find($id);

        if (!$league) {
            return new JsonResponse(['message' => 'League not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $chessRounds->createRoundsAndGames($league);

        return $this->json(['msg' => 'Rondas y partidas creadas exitosamente']);
    }

    #[Route('api/show/create/rounds&games', name: 'app_show_create_rounds_games', methods: ['POST'])]
    public function showRoundNDGames(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $game = $this->doctrine->getRepository(Game::class)->findAllGame();



        return $this->json([
            'message' => 'Games created.',
            'data' => $game,
        ],
            200);
    }
}
