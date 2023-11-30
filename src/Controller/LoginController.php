<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends AbstractController
{
    private $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    #[Route('/api/login_check', name: 'app_login')]
    public function login(Request $request): JsonResponse
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        // Aquí realiza la autenticación del usuario (puedes usar FOSUserBundle o Symfony Guard)

        // Si la autenticación es exitosa, genera y devuelve un token JWT
        $token = $this->jwtManager->create($user);

        return $this->json(['token' => $token]);
    }


    //$userFake = ['full_name' => "hola", "password" => '123'];
//        $user = $doctrine->getRepository(User::class)->findAll();
//        $userData = [];
//
//        foreach ($user as $datauser) {
//            $userData[] = [
//                'id' => $datauser->getId(),
//                'full_name' => $datauser->getFullName(),
//                'email' => $datauser->getEmail(),
//                'password' => $datauser->getPassword(),
//                'roles'  => $datauser->getRoles(),
//            ];
//        }
//
//
//        return $this->json($userData);
//        //dump($user);

}
