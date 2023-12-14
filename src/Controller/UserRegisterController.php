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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserRegisterController extends AbstractController
{
    use WithFormErrors;

    private UserPasswordHasherInterface $userPasswordHasher;

    //Inyectamos la interfaaz para hashear la contraseña
    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->em = $em;
    }

    // CAMBIAR NOMBRE
    #[Route('api/user/register', name: 'user_register', methods: ['POST'])]
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

    #[Route('api/user/list', name: 'user_list', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine,
                           TokenStorageInterface $tokenStorage,
                           Security $security,
                           JWTTokenManagerInterface $tokenManager,
                           Request $request,
                           UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $userList = $doctrine->getRepository(User::class)->findAllUser();
//        $response = json_encode($userList);
//        $userData = [];

        /*foreach ($user as $datauser) {
            $userData[] = [
                'id' => $datauser->getId(),
                'full_name' => $datauser->getFullName(),
                'email' => $datauser->getEmail(),
                'password' => $datauser->getPassword(),
                'roles'  => $datauser->getRoles(),
            ];
        }*/


        $em = $doctrine->getManager();

        return $this->json([
            'message' => 'User list recover',
            'data' => $userList],
            200);


    }
}

