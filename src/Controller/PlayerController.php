<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class PlayerController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('api/player/register', name: 'app_player_register', methods: ['POST'])]
    public function register(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $player = new Player();
        $form = $this->createForm(PlayerRegisterType::class, $player);
        $form->submit($data);

        $this->em->persist($player);
        $this->em->flush();

        return $this->json(['message' => 'Player created succesfully', 'player' => $player, 201]);
    }

    #[Route('api/player/showPJ', name: 'app_player_list', methods: ['GET'])]
    public function showPJ(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $pj_list = $doctrine->getRepository(Player::class)->findAllPJ();

        $em = $doctrine->getManager();

        return $this->json([
            'message' => 'Player list recover',
            'data' => $pj_list],
            200);
    }

    #[Route('api/player/showPJId', name: 'app_player_list_id', methods: ['POST'])]
    public function showPJId(/*ManagerRegistry $doctrine,*/ Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['ids'])) {
            return new JsonResponse(['error' => 'Se requieren IDs para la consulta.'], 400);
        }

        $ids = is_array($data['ids']) ? $data['ids'] : explode(',', $data['ids']);

        $this->serizalizer = $serializer;

        $repo = $this->em->getRepository(Player::class);
        $queryBuilder = $repo->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids);

        $result = $queryBuilder
                ->getQuery()
                ->getResult();

        $json = $serializer->serialize($result, 'json');
        $response = new JsonResponse($json, 200, [], true);

        return $response;

    }
}
