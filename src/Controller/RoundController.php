<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Player;
use App\Entity\Round;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoundController extends AbstractController
{
    public function __construct (EntityManagerInterface $em, ManagerRegistry $doctrine)
    {
        $this->em = $em;
        $this->doctrine = $doctrine;

    }
    #[Route('api/round/create', name: 'app_round_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $leagueName = $data['league_name'];
        $league = $this->doctrine->getRepository(League::class);
        $idL = $league
            ->findOneBy(['league_name' => $leagueName])
            ->getId();


        // YA TENGO EL ID DE LA LIGA, AHORA TENGO QUE PROBAR QUE ME GENERA LAS RONDAS
        // LAS RONDAS TIENEN QUE TENER LOS JUGADORES, PIENSA COMO LOS VOY A METER...
        // ADEMÁS LAS PARTIDAS VAN ASOCIADAS A LAS RONDAS, CREO Q SERÍA ÓPTIMO QUE ESTUVIESEN ENGLOBADAS

//        $round = new Round();
//        $round->setIdLeagueFk($idL);
//
//        $this->em->persist($round);
//        $this->em->flush();


        return $this->json([
//            'message' => 'Round created successfully',
            'data' => $idL,
        ],
            200);
    }
}
