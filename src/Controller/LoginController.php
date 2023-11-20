<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'api_app_login')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LoginController.php',
        ]);
    }
/*
    //Metodo para acceder al sistema
    public function login(Security $security, UserInterface $user, JWTTokenManagerInterface $JWTManager) {
        try {
            $repository = $this->doctrine->getRepository(User::class);
            $object = $security->getUser();
            $object->setToken($JWTManager->create($user));
            $message = $repository->login($object);
        } catch(\Exception $e) {
            $message = $e->getMessage();
        }

        return $this->json($message);
    }*/
}
