<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
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
     * @throws JWTDecodeFailureException
     */
    public function token(ManagerRegistry $doctrine,
                          Security $security,
                          UserInterface $user,
                          JWTTokenManagerInterface $JWTManager,
                          TokenStorageInterface $tokenStorage
    )
    {
        $em = $doctrine->getManager();
        // Obtén el token actual del token storage
        $token = $tokenStorage->getToken();
        // Crea un nuevo token para el usuario actual
        $jwtToken = $JWTManager->create($user);

        if ($token) {
            try {
                //Almacenamos token en BD
                $object = $security->getUser();
                $object->setJwtToken($jwtToken);

                $em->persist($object);
                $em->flush();

            } catch(\Exception $e) {
                $message = $e->getMessage();
            }

            $jwtRole = $token->getRoleNames();
            $id = $token->getUserIdentifier();
            $name_chess = $doctrine
                ->getRepository(User::class)
                ->find($id)
                ->getUsernameInChess();
            $name = $doctrine
                ->getRepository(User::class)
                ->find($id)
                ->getFullName();


            return new JsonResponse([$jwtRole, $id, $jwtToken, $name, $name_chess]);
        }
        // Manejar el caso en el que no se pudo obtener el token
        return new JsonResponse(['error' => 'No se pudo obtener el token'], 500);
    }
}
