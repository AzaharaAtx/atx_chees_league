<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    public function __construct (EntityManagerInterface $em, ManagerRegistry $doctrine)
    {
        $this->em = $em;
        $this->doctrine = $doctrine;

    }
    #[Route('api/game/create', name: 'app_game_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $game = new Game();
        $game
            ->setStatus('Initial state');
            //->setIdRoundFk(); // PARA ACCEDER AL ID DE RONDA DEBEMOS TRAER EL REPOSITORY

        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
