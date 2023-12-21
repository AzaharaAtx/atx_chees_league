<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\LeaguePlayer;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        $playerLeague = new LeaguePlayer();
        $playerLeague
            ->setIdLeagueFk($idL);

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

    #[Route('api/league/{idL}/addP/{idP}', name: 'app_league_addP', methods: ['GET'])]
    public function addParticipants(int $idL, int $idP): Response
    {
        $doctrine = $this->doctrine->getManager();

        $league = $doctrine->getRepository(LeaguePlayer::class)->find($idL);
        $player = $doctrine->getRepository(Player::class)->find($idP);
        $player = $player->getId();

        if(!$league) {
            throw $this->createNotFoundException('No se encontró la liga');
        }
        elseif (!$player){
            throw $this->createNotFoundException('No se encontró al jugador');
        }

        $league->setIdPlayerFk($player);
        $doctrine->flush();

        return $this->json(['msg' => 'Jugador añadido exitosamente']);

    }


}
