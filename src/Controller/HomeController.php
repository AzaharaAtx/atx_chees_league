<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class HomeController extends AbstractController
{

    #[Route('api/home', name: 'app_home')]
    public function home(TokenStorageInterface $tokenStorage): JsonResponse
    {
        $token = $tokenStorage->getToken();
        $user = $token->getUser();

        return $this->json([$token, $user]);
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     * @return JsonResponse
     */
    public function token(ManagerRegistry $doctrine,Security $security, UserInterface $user, JWTTokenManagerInterface $JWTManager, TokenStorageInterface $tokenStorage)
    {
        $em = $doctrine->getManager();
        // Obtén el token actual del token storage
        $token = $tokenStorage->getToken();
        $jwtToken = $JWTManager->create($user);

        if ($token) {
            // Accede al token de autenticación
//            $jwtToken = $token->JWTUserToken::getCredentials();
            try {

                $object = $security->getUser();

                $object->setJwtToken($jwtToken);

                $em->persist($object);
                $em->flush();
            } catch(\Exception $e) {
                $message = $e->getMessage();
            }

            // Ahora `$jwtToken` contiene el token JWT que puedes devolver o utilizar según tus necesidades.
            return new JsonResponse(['token' => $jwtToken, 'test' => '1']);
        }

        // Manejar el caso en el que no se pudo obtener el token
        return new JsonResponse(['error' => 'No se pudo obtener el token'], 500);
    }
}
