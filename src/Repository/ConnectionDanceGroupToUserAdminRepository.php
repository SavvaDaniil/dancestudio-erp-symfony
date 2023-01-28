<?php

namespace App\Repository;

use App\Entity\ConnectionDanceGroupToUserAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConnectionDanceGroupToUserAdmin>
 *
 * @method ConnectionDanceGroupToUserAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConnectionDanceGroupToUserAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConnectionDanceGroupToUserAdmin[]    findAll()
 * @method ConnectionDanceGroupToUserAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConnectionDanceGroupToUserAdminRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConnectionDanceGroupToUserAdmin::class);
    }

    public function save(ConnectionDanceGroupToUserAdmin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ConnectionDanceGroupToUserAdmin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ConnectionDanceGroupToUserAdmin[] Returns an array of ConnectionDanceGroupToUserAdmin objects
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

//    public function findOneBySomeField($value): ?ConnectionDanceGroupToUserAdmin
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
