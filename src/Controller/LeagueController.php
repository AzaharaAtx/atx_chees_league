<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\LeaguePlayer;
use App\Entity\Player;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LeagueController extends AbstractController
{
    public function __construct(EntityManagerInterface $em, ManagerRegistry $doctrine){
        $this->em = $em;
        $this->doctrine = $doctrine;
    }
    #[Route('api/league/create', name: 'app_league_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $leagueName = $data['league_name'];
        $league = new League();

        $league
            ->setLeagueName($leagueName)
            ->setStatus('Initial state');

        $this->em->persist($league);
        $this->em->flush();

        //despues de crear
        $idL = $league->getId();

        return $this->json([
        'message' => 'League created successfully',
        'data' => $league,
        ],
        200);
    }

    #[Route('api/league/read', name: 'app_league_read', methods: ['GET'])]
    public function read(Request $request): Response
    {
        $leagueList = $this->doctrine
                            ->getRepository(League::class)
                            ->findAllLeague();

        return $this->json([
            'message' => 'League list recover',
            'data' => $leagueList],
            200);
    }
    #[Route('api/league/state', name: 'app_league_state', methods: ['GET'])]
    public function state(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $leagueName = $data['league_name'];

        $league = $this->doctrine->getRepository(League::class);
        $state = $league
            ->findOneBy(['league_name' => $leagueName])
            ->getStatus();

        $leagueOpen = strtolower($state) === 'initial state';

        return $this->json([
            'message' => 'State league recover',
            'data' => $leagueOpen],
            200);
    }

    #[Route('api/league/view_init_league', name: 'app_league_init_league', methods: ['GET'])]
    public function viewInitLeague(Request $request, SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(), true);

        $league = $this->doctrine->getRepository(League::class)->findBy(['status' => 'Initial state']);
        $json = $serializer->serialize($league, 'json');

        return $this->json([
            /*'message' => 'Open leagues',
            'data' => */$json],
            200);
    }

    #[Route('api/league/enroll/{id}', name: 'app_league_enroll', methods: ['POST'])]
    public function enroll(int $id, Request $request, Security$security): JsonResponse
    {
        $doctrine = $this->doctrine->getManager();
        $em = $this->em;
        $user = $security->getUser();

        $league = $doctrine->getRepository(League::class)->find($id);

        if (!$league) {
            return new JsonResponse(['message' => 'League not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $player_league = new LeaguePlayer();
        $player_league
            ->setIdLeagueFk($league)
            ->setIdUserFk($user);

        $em->persist($player_league);
        $em->flush();

        return $this->json([$user, 'msg' => 'Jugador añadido exitosamente']);
    }

    #[Route('api/league/view_open_league', name: 'app_league_open_league', methods: ['GET'])]
    public function viewOpenLeague(Request $request, SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(), true);

        $league = $this->doctrine->getRepository(League::class)->findBy(['status' => 'Open']);
        $json = $serializer->serialize($league, 'json');

        return $this->json([
            /*'message' => 'Open leagues',
            'data' => */$json],
            200);
    }


}
