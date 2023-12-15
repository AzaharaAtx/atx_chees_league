<?php

namespace App\Repository;

use App\Entity\LeaguePlayer;
use App\Queries\LeaguePlayerQuery\LeaguePlayerQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LeaguePlayer>
 *
 * @method LeaguePlayer|null find($id, $lockMode = null, $lockVersion = null)
 * @method LeaguePlayer|null findOneBy(array $criteria, array $orderBy = null)
 * @method LeaguePlayer[]    findAll()
 * @method LeaguePlayer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeaguePlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LeaguePlayer::class);
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

        $query = new LeaguePlayerQuery();
        $result = $this->selection($query, $condition, $ordenation, $limit);

        return $result;

    }

//    /**
//     * @return LeaguePlayer[] Returns an array of LeaguePlayer objects
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

//    public function findOneBySomeField($value): ?LeaguePlayer
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
