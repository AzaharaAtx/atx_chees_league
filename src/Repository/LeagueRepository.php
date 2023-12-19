<?php

namespace App\Repository;

use App\Entity\League;
use App\Queries\LeagueQuery\LeagueQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<League>
 *
 * @method League|null find($id, $lockMode = null, $lockVersion = null)
 * @method League|null findOneBy(array $criteria, array $orderBy = null)
 * @method League[]    findAll()
 * @method League[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeagueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, League::class);
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
    public function findAllLeague()
    {
        //condiciones
        $condition  = '';
        //ordenaciones
        $ordenation = ' ORDER BY u.id DESC ';
        //limites
        $limit    = '';

        $query = new LeagueQuery();
        $result = $this->selection($query, $condition, $ordenation, $limit);

        return $result;

    }

//    /**
//     * @return League[] Returns an array of League objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?League
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
