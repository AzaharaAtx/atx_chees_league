<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;


class LoginController extends AbstractController
{
    #[Route('/login_chess', name: 'api_app_login'/*,  methods: ['POST']*/)]
    public function index(): string
    {
        //$user = $doctrine->getRepository(User::class)->findAll();
        //$find = json_decode($user);

       // return $this->json($user);
        return "Hola";

    }

}
