<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\LeaguePlayer;
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

        return $this->json($leagueList,200);
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

    #[Route('api/league/view/init/league', name: 'app_league_init_league', methods: ['GET'])]
    public function viewInitLeague(Request $request, SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(), true);

        $league = $this->doctrine->getRepository(League::class)->findBy(['status' => 'Initial state']);
        $json = $serializer->serialize($league, 'json');

        return $this->json([$json], 200);
    }

    #[Route('api/league/enroll/{id}', name: 'app_league_enroll', methods: ['POST'])]
    public function enroll(int $id, Request $request, Security $security): JsonResponse
    {
        $doctrine = $this->doctrine->getManager();
        $em = $this->em;
        $user = $security->getUser();

        $league = $doctrine->getRepository(League::class)->find($id);

        if (!$league) {
            return new JsonResponse(['message' => 'League not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $existingEnrollment = $doctrine->getRepository(LeaguePlayer::class)
            ->findOneBy(['id_league_fk' => $league, 'id_user_fk' => $user]);

        if ($existingEnrollment) {
            return new JsonResponse(['message' => 'User already enrolled in the league'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $player_league = new LeaguePlayer();
        $player_league
            ->setIdLeagueFk($league)
            ->setIdUserFk($user);

        $em->persist($player_league);
        $em->flush();

        return $this->json([$user, 'message' => 'Jugador añadido exitosamente']);
    }

    #[Route('api/league/view/open/league', name: 'app_league_open_league', methods: ['GET'])]
    public function viewOpenLeague(Request $request, SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(), true);

        $league = $this->doctrine->getRepository(League::class)->findBy(['status' => 'Open']);
        $json = $serializer->serialize($league, 'json');

        return $this->json([$json],200);
    }
    #[Route('api/league/view/close/league', name: 'app_league_close_league', methods: ['GET'])]
    public function viewClosedLeagues(Request $request, SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(), true);

        $league = $this->doctrine->getRepository(League::class)->findBy(['status' => 'Close']);
        $json = $serializer->serialize($league, 'json');

        return $this->json([$json],200);
    }

    #[Route('api/league/view/edit/league/{id}', name: 'app_league_edit_league', methods: ['PUT'])]
    public function editLeague(Request $request, SerializerInterface $serializer, int $id): Response
    {
        $doctrine = $this->doctrine->getManager();
        $em = $this->em;
        $league = $doctrine->getRepository(League::class)->find($id);

        if (!$league) {
            return $this->json(['error' => 'Liga no encontrada.'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['status'])) {
            $league->setStatus($data['status']);
        }

        if (isset($data['start_date'])) {
            $league->setStartDate(new \DateTime($data['start_date']));
        }

        if (isset($data['end_date'])) {
            $league->setEndDate(new \DateTime($data['end_date']));
        }

        if (isset($data['winner_league'])) {
            $league->setWinnerLeague($data['winner_league']);
        }

        $doctrine->flush();

        return $this->json(['msg' => 'Liga actualizada con exito'],200);
    }

}
