<?php

namespace App\Repository;

use App\Entity\ConnectionDiscountToUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConnectionDiscountToUser>
 *
 * @method ConnectionDiscountToUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConnectionDiscountToUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConnectionDiscountToUser[]    findAll()
 * @method ConnectionDiscountToUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectionDiscountToUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnectionDiscountToUser::class);
    }

    public function save(ConnectionDiscountToUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConnectionDiscountToUser $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConnectionDiscountToUser[] Returns an array of ConnectionDiscountToUser objects
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

//    public function findOneBySomeField($value): ?ConnectionDiscountToUser
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
