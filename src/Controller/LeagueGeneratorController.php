<?php

namespace App\Controller;

use App\Entity\League;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeagueGeneratorController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine){

    }
    #[Route('/league/generator', name: 'app_league_generator')]
    public function generate(Request $request): Response
    {
        $em = $this->doctrine->getManager();

        $league = new League();
        $em->persist($league);
        $em->flush();

        $idL = $league->getId();


        return $this->render('league_generator/index.html.twig', [
            'controller_name' => 'LeagueGeneratorController',
        ]);
    }

    private function generatePlayers(Request $request,$idLeague)
    {


    }
}
