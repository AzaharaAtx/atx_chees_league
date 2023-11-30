<?php

namespace App\Repository;

use App\Entity\User;
use App\Queries\UserQuery\UserQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
* @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Actualiza la nueva contraseña hasheada para el usuario, tras login
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // Verifica si la interfaz PasswordAuthenticatedUserInterface está implementada por el usuario.
        if (!$user instanceof User) {
            // Si el usuario no es una instancia de la clase User, lanza una excepción UnsupportedUserException.
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }
        // Establece la nueva contraseña hasheada para el usuario.
        $user->setPassword($newHashedPassword);
        // Obtiene el EntityManager y persiste los cambios en el usuario.
        $this->getEntityManager()->persist($user);
        // Realiza el flush para sincronizar los cambios en la base de datos.
        $this->getEntityManager()->flush();
    }

    /**
     * @throws Exception
     * conditions, ordenations, limits -> marcador/localizador front
     */
    public function selection($query, $condition, $ordenation, $limit)
    {
        // Tratar SQL y preparacion
        $sql = $query->getQuery();
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

    // Metodo para listar usuarios por id
    public function findUser($id)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT user.id, user.email, user.roles, user.last_name, user.full_name 
                FROM App:User user
                WHERE user.id =:id'
            )
            ->setParameter('id', $id)
            ->getResult();
    }

    // Método listado completo
    public function findAllUser()
    {
        //condiciones
        $condition  = '';
        //ordenaciones
        $ordenation = ' ORDER BY u.id DESC ';
        //limites
        $limit    = '';

        $query = new UserQuery();
        $result = $this->selection($query, $condition, $ordenation, $limit);

        return $result;

    }


//
//    /**
//     * @return User[] Returns an array of User objects
//     */
//
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
