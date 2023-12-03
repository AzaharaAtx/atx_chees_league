<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Trait\WithFormErrors;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

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
    #[Route('api/user/register', name: 'user_register', methods: ['POST'])]
    public function create(Request $request, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);
        $form->submit($data);

        if(!$form->isValid()) {
            $errors = $this->getErrors($form);
            return $this->json(['errors' => $errors], 400);
        }

        $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));
        $user->setRoles(['ROLE_USER']);
        $this->em->persist($user);
        $this->em->flush();



        return $this->json([
            'message' => 'User created successfully',
            'user' => $user],
        201);
    }

}
