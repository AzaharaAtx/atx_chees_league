<?php

namespace App\Repository;

use App\Entity\Round;
use App\Queries\RoundQuery\RoundQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Round>
 *
 * @method Round|null find($id, $lockMode = null, $lockVersion = null)
 * @method Round|null findOneBy(array $criteria, array $orderBy = null)
 * @method Round[]    findAll()
 * @method Round[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoundRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Round::class);
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
    public function findAllRound()
    {
        //condiciones
        $condition  = '';
        //ordenaciones
        $ordenation = ' ORDER BY u.id DESC ';
        //limites
        $limit    = '';

        $query = new RoundQuery();
        $result = $this->selection($query, $condition, $ordenation, $limit);

        return $result;

    }

//    /**
//     * @return Round[] Returns an array of Round objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Round
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
