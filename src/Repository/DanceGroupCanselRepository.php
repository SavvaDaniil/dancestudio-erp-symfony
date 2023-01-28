<?php

namespace App\Repository;

use App\Entity\DanceGroupCansel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DanceGroupCansel>
 *
 * @method DanceGroupCansel|null find($id, $lockMode = null, $lockVersion = null)
 * @method DanceGroupCansel|null findOneBy(array $criteria, array $orderBy = null)
 * @method DanceGroupCansel[]    findAll()
 * @method DanceGroupCansel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DanceGroupCanselRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DanceGroupCansel::class);
    }

    public function save(DanceGroupCansel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DanceGroupCansel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DanceGroupCansel[] Returns an array of DanceGroupCansel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DanceGroupCansel
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
