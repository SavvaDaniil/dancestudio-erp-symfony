<?php

namespace App\Repository;

use App\Entity\ConnectionAbonementToDanceGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConnectionAbonementToDanceGroup>
 *
 * @method ConnectionAbonementToDanceGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConnectionAbonementToDanceGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConnectionAbonementToDanceGroup[]    findAll()
 * @method ConnectionAbonementToDanceGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectionAbonementToDanceGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnectionAbonementToDanceGroup::class);
    }

    public function save(ConnectionAbonementToDanceGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConnectionAbonementToDanceGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConnectionAbonementToDanceGroup[] Returns an array of ConnectionAbonementToDanceGroup objects
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

//    public function findOneBySomeField($value): ?ConnectionAbonementToDanceGroup
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
