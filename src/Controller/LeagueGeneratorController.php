<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LeagueGeneratorController extends AbstractController
{
    #[Route('/league/generator', name: 'app_league_generator')]
    public function generate(): Response
    {
        return $this->render('league_generator/index.html.twig', [
            'controller_name' => 'LeagueGeneratorController',
        ]);
    }
}
