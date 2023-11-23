<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserRegisterController extends AbstractController
{
    private UserPasswordHasherInterface $userPasswordHasher;

    //Inyectamos la interfaaz para hashear la contraseña
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
    #[Route('/user/register', name: 'app_user_register')]
    public function create(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        //Verificar si el usuario ya existe
        $userExist = $doctrine->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if ($userExist) {
            return new JsonResponse(['error' => 'El usuario con este correo electrónico ya existe'], Response::HTTP_CONFLICT);
        }

        //Crear una nueva instancia de User
        $user = new User();
        $user->setEmail($data['email']);
        $user->setFullName($data['full_name']);
        $user->setLastName($data['last_name']);
        $user->setUserPlayer($data['user_player']);
        $user->setUserRole($data['roles']);

        //Crear y hashear la contraseña antes de almacenarla
        $hash = $this->userPasswordHasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setPassword($hash);

        //Guardamos el nuevo usuario
        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'Usuario creado con éxito'.$user->getUser()], Response::HTTP_CREATED);
    }
}
