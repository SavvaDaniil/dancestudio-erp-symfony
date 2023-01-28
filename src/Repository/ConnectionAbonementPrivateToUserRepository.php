<?php

namespace App\Repository;

use App\Entity\ConnectionAbonementPrivateToUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConnectionAbonementPrivateToUser>
 *
 * @method ConnectionAbonementPrivateToUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConnectionAbonementPrivateToUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConnectionAbonementPrivateToUser[]    findAll()
 * @method ConnectionAbonementPrivateToUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectionAbonementPrivateToUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnectionAbonementPrivateToUser::class);
    }

    public function save(ConnectionAbonementPrivateToUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConnectionAbonementPrivateToUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConnectionAbonementPrivateToUser[] Returns an array of ConnectionAbonementPrivateToUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ConnectionAbonementPrivateToUser
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
