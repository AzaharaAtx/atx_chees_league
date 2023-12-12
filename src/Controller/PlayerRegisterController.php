<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PlayerRegisterController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('api/player/register', name: 'app_player_register', methods: ['POST'])]
    public function createPlayer(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $player = new Player();
        $form = $this->createForm(PlayerRegisterType::class, $player);
        $form->submit($data);

        $this->em->persist($player);
        $this->em->flush();

        return $this->json(['message' => 'Player created succesfully', 'player' => $player, 201]);
    }
}
