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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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
    #[Route('api/show/my/leagues', name: 'app_league_participate', methods: ['GET'])]
    public function showMe(Request $request, SerializerInterface $serializer, Security $security): Response
    {
        $user = $security->getUser();

        $league_player = $this->doctrine
            ->getRepository(Game::class)
            ->findBy([/*'status' => 'Pending',*/ 'white_player_fk' => $user/*, 'black_player_fk' => $user*/]);


        $json = $serializer->serialize($league_player, 'json');
        return $this->json([$json],200);
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



        return $this->json($game);
    }

    #[Route('api/edit/status-game/{id}', name: 'app_edit_status-game', methods: ['PUT'])]
    public function editStatus(Request $request, int $id): Response
    {
        $doctrine = $this->doctrine->getManager();
        $em = $this->em;
        $edit = $doctrine->getRepository(LeaguePlayer::class)->find($id);
        if (!$edit) {
            return $this->json(['error' => 'Game no encontrado.'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['defeats_number'])) {
            $edit->setDefeatsNumber($data['defeats_number']);
        }
        if (isset($data['wins_number'])) {
            $edit->setWinsNumber($data['wins_number']);
        }

        return $this->json(200);
    }

    #[Route('api/show/league-players', name: 'app_show_leagues_player', methods: ['GET'])]
    public function showRelation(Request $request): Response
    {
        $game = $this->doctrine->getRepository(LeaguePlayer::class)->findAllParticipants();

        return $this->json($game);
    }



}
