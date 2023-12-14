<?php

namespace App\Controller;

use App\Entity\League;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeagueGeneratorController extends AbstractController
{
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    //  CAMBIAR NOMBRE Y USAR BIENAS PRACTICAS
    #[Route('api/league/create', name: 'app_league_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
//        $em = $this->doctrine->getManager();

        $leagueName = $data['name_league'];
        $league = new League();
        $league->setNameLeague($leagueName);

        $this->em->persist($league);
        $this->em->flush();

        //despues de crear
        $idL = $league->getId();

        return $this->json([
        'message' => 'League created successfully',
        'league' => $league,
        ],
        200);
    }

    private function generatePlayers(Request $request,$idLeague)
    {
        /*$form = $this->createForm(PlayerLeagueType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();

            $player = $form->getData();
            $playerLeague = new Player();
            $playerLeague->addLeague($em->getRepository(League::class)->findBy($idLeague));



        }*/

    }
}
