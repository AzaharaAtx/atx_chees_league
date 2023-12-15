<?php

namespace App\Repository;

use App\Entity\Game;
use App\Queries\GameQuery\GameQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function selection($query, $condition, $ordenation, $limit)
    {
        // Tratar SQL y preparacion
        $sql = $query->getSQL();
        $sql = str_replace('{{conditions}}', $condition, $sql);
        $sql = str_replace('{{ordenations}}', $ordenation, $sql);
        $sql = str_replace('{{limits}}', $limit, $sql);
        $connection = $this->getEntityManager()->getConnection()->prepare($sql);
        // Ejecuto
        $connectionResult = $connection->executeQuery();
        // Obtener información
        $result = $connectionResult->fetchAllAssociative();

        return $result;
    }

    // Método listado completo
    public function findAllGame()
    {
        //condiciones
        $condition  = '';
        //ordenaciones
        $ordenation = ' ORDER BY u.id DESC ';
        //limites
        $limit    = '';

        $query = new GameQuery();
        $result = $this->selection($query, $condition, $ordenation, $limit);

        return $result;

    }

//    /**
//     * @return Game[] Returns an array of Game objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Game
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
