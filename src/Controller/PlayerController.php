<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerRegisterType;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class PlayerController extends AbstractController
{
    private $em;
    private $serializer;
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }


    #[Route('api/player/showPJId', name: 'app_player_list_id', methods: ['POST'])]
    public function showPJId(Request $request, SerializerInterface $serializer): JsonResponse
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

        return new JsonResponse($json, 200, [], true);
    }

    /***
     * Hidratación:
     *
     * Argumento AbstractQuery::HYDRATE_ARRAY impone que los resultados se devuelvan
     * como un array simple en lugar de objetos de entidad.
     *
     * */
    #[Route('api/player/criteria', name: 'app_player_list_criteria', methods: ['POST'])]
    public function criteria(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['usernames'])) {
            return new JsonResponse(['error' => 'Se requieren usernames para la consulta.'], 400);
        }

        $usernames = is_array($data['usernames']) ? $data['usernames'] : explode(',', $data['usernames']);
        $repo = $this->em->getRepository(Player::class);
        $queryBuilder = $repo->createQueryBuilder('p')
            ->select('p.id')
            ->where('p.username_in_chess IN (:usernames)')
            ->setParameter('usernames', $usernames);

        $ids = $queryBuilder
            ->getQuery()
            ->getResult(AbstractQuery::HYDRATE_ARRAY);

        $response = new JsonResponse($ids, 200);

        return $response;
    }
}
