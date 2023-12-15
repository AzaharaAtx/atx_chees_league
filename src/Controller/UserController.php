<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Trait\WithFormErrors;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    use WithFormErrors;

    private UserPasswordHasherInterface $userPasswordHasher;

    //Inyectamos la interfaaz para hashear la contraseña
    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->em = $em;
    }

    // OJO CON LAS RUTAS EN .yml CORREGIR
    #[Route('api/user/create', name: 'user_create', methods: ['POST'])]
    public function create(ManagerRegistry $doctrine,
                           TokenStorageInterface $tokenStorage,
                           Security $security,
                           JWTTokenManagerInterface $tokenManager,
                           Request $request,
                           UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);
        $form->submit($data);

        if (!$form->isValid()) {
            $errors = $this->getErrors($form);
            return $this->json(['errors' => $errors], 400);
        }

        $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));
        $user->setRoles(['ROLE_USER']);
        $this->em->persist($user);
        $this->em->flush();

        $em = $doctrine->getManager();
        $token = $tokenManager->create($user);
        $jwtToken = $tokenStorage->getToken();

        if ($jwtToken) {
            try {
                //Almacenamos token en BD
                $object = $security->getUser();

                $object->setJwtToken($token);

                $em->persist($object);
                $em->flush();

            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }


        return $this->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token],
            201);


    }

    #[Route('api/user/show', name: 'user_list', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $userList = $doctrine->getRepository(User::class)->findAllUser();

        $em = $doctrine->getManager();

        return $this->json([
            'message' => 'User list recover',
            'data' => $userList],
            200);


    }
}

