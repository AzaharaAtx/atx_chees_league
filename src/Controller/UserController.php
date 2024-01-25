<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Trait\WithFormErrors;
use Doctrine\ORM\AbstractQuery;
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
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    use WithFormErrors;

    private UserPasswordHasherInterface $userPasswordHasher;

    //Inyectamos la interfaaz para hashear la contraseña
    public function __construct(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em, ManagerRegistry $doctrine)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->em = $em;
        $this->doctrine = $doctrine;
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
        $user_form = $this->createForm(UserType::class, $user, ['csrf_protection' => false]);
        $user_form->submit($data);

        if (!$user_form->isValid()) {
            $errors = $this->getErrors($user_form);
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
    public function list(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $userList = $doctrine->getRepository(User::class)->findAllUser();

        $em = $doctrine->getManager();

        return $this->json($userList,200);
    }

    #[Route('api/user/profile', name: 'user_profile', methods: ['GET'])]
    public function userId(ManagerRegistry $doctrine, Request $request, Security $security): JsonResponse
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Usuario no encontrado');
        }

        return $this->json($user,200);
    }

    #[Route('/api/user', name: 'edit_user', methods: ['PUT'])]
    public function edit(Request $request,Security $security, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $doctrine = $this->doctrine->getManager();
        $em = $this->em;
        $id = $security->getUser();
        $user = $doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado.'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['full_name'])) {
            $user->setFullName($data['full_name']);
        }

        if (isset($data['last_name'])) {
            $user->setLastName($data['last_name']);
        }

        if (isset($data['password'])) {
            $encodedPassword = $userPasswordHasher->hashPassword($user, $data['password']);
            $user->setPassword($encodedPassword);
        }

        if (isset($data['username_in_chess'])) {
            $user->setUsernameInChess($data['username_in_chess']);
        }

        if (isset($data['friend_link'])) {
            $user->setFriendLink($data['friend_link']);
        }

        if (isset($data['phone'])) {
            $user->setPhone($data['phone']);
        }

        $doctrine->flush();

        return $this->json(['message' => 'Usuario actualizado con éxito.'], 200);
    }
    #[Route('/api/user/{id}', name: 'edit_my_user', methods: ['PUT'])]
    public function editById(Request $request,int $id, UserPasswordHasherInterface $userPasswordHasher): JsonResponse
    {
        $doctrine = $this->doctrine->getManager();
        $em = $this->em;
        $user = $doctrine->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado.'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (isset($data['full_name'])) {
            $user->setFullName($data['full_name']);
        }

        if (isset($data['last_name'])) {
            $user->setLastName($data['last_name']);
        }

        if (isset($data['password'])) {
            $encodedPassword = $userPasswordHasher->hashPassword($user, $data['password']);
            $user->setPassword($encodedPassword);
        }

        if (isset($data['username_in_chess'])) {
            $user->setUsernameInChess($data['username_in_chess']);
        }

        if (isset($data['friend_link'])) {
            $user->setFriendLink($data['friend_link']);
        }

        if (isset($data['phone'])) {
            $user->setPhone($data['phone']);
        }

        $doctrine->flush();

        return $this->json(['message' => 'Usuario actualizado con éxito.'], 200);
    }

    #[Route('api/user/showUId', name: 'app_user_list_id', methods: ['POST'])]
    public function showUId(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['ids'])) {
            return new JsonResponse(['error' => 'Se requieren IDs para la consulta.'], 400);
        }

        $ids = is_array($data['ids']) ? $data['ids'] : explode(',', $data['ids']);

        $this->serizalizer = $serializer;

        $repo = $this->em->getRepository(User::class);
        $queryBuilder = $repo->createQueryBuilder('u')
            ->where('u.id IN (:ids)')
            ->setParameter('ids', $ids);

        $result = $queryBuilder
            ->getQuery()
            ->getResult();

        $json = $serializer->serialize($result, 'json');
        $response = new JsonResponse($json, 200, [], true);

        return $response;
    }

    /***
     * Hidratación:
     *
     * Argumento AbstractQuery::HYDRATE_ARRAY impone que los resultados se devuelvan
     * como un array simple en lugar de objetos de entidad.
     *
     * */
    #[Route('api/user/criteria', name: 'app_user_list_criteria', methods: ['POST'])]
    public function criteria(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['usernames'])) {
            return new JsonResponse(['error' => 'Se requieren usernames para la consulta.'], 400);
        }

        $usernames = is_array($data['usernames']) ? $data['usernames'] : explode(',', $data['usernames']);
        $repo = $this->em->getRepository(User::class);
        $queryBuilder = $repo->createQueryBuilder('u')
            ->select('u.id')
            ->where('u.username_in_chess IN (:usernames)')
            ->setParameter('usernames', $usernames);

        $ids = $queryBuilder
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        $response = new JsonResponse($ids, 200);

        return $response;
    }

}

