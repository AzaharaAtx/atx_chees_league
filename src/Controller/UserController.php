<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $em;

    /**
     * @param $em
     *
     */

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/user/{id}', name: 'app_user')]
    public function index($id): JsonResponse
    {
        $user = $this->em->getRepository(Player::class)->find($id);
        return $this->json(['user' => $user]);


    }
}
