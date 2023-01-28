<?php

namespace App\Repository;

use App\Entity\ConnectionUserToDanceGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConnectionUserToDanceGroup>
 *
 * @method ConnectionUserToDanceGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConnectionUserToDanceGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConnectionUserToDanceGroup[]    findAll()
 * @method ConnectionUserToDanceGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectionUserToDanceGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnectionUserToDanceGroup::class);
    }

    public function save(ConnectionUserToDanceGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConnectionUserToDanceGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConnectionUserToDanceGroup[] Returns an array of ConnectionUserToDanceGroup objects
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

//    public function findOneBySomeField($value): ?ConnectionUserToDanceGroup
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
