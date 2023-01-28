<?php

namespace App\Repository;

use App\Entity\PurchaseAbonement;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PurchaseAbonement>
 *
 * @method PurchaseAbonement|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseAbonement|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseAbonement[]    findAll()
 * @method PurchaseAbonement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseAbonementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurchaseAbonement::class);
    }

    public function save(PurchaseAbonement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PurchaseAbonement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?PurchaseAbonement {
        return $this->createQueryBuilder("purchase_abonement")
            ->andWhere("purchase_abonement.id = :id")
            ->setParameter("id", $id)
            ->orderBy('purchase_abonement.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByIdAndUserId(int $id, int $userId): ?PurchaseAbonement {
        return $this->createQueryBuilder("purchase_abonement")
            ->leftJoin("purchase_abonement.user", "user")
            ->andWhere("user.id = :userId")
            ->setParameter("userId", $userId)
            ->andWhere("purchase_abonement.id = :id")
            ->setParameter("id", $id)
            ->orderBy('purchase_abonement.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return PurchaseAbonement[] Returns an array of Abonement objects
    */
    public function listAllByUserId(int $userId): array
    {
        return $this->createQueryBuilder('purchase_abonement')
            ->leftJoin("purchase_abonement.user", "user")
            ->innerJoin("purchase_abonement.abonement", "abonement")
            ->andWhere("user.id = :userId")
            ->setParameter("userId", $userId)
            ->orderBy('purchase_abonement.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return PurchaseAbonement[] Returns an array of Abonement objects
    */
    public function listAllActiveByUserIdWithIncludeAbonement(int $userId, string $dateOfBuy): array
    {
        return $this->createQueryBuilder('purchase_abonement')
            ->leftJoin("purchase_abonement.user", "user")
            ->innerJoin("purchase_abonement.abonement", "abonement")
            ->andWhere("user.id = :userId")
            ->setParameter("userId", $userId)
            ->andWhere("purchase_abonement.visits_left != '0' AND (purchase_abonement.date_of_activation IS NULL OR purchase_abonement.date_of_must_be_used_to IS NULL OR purchase_abonement.date_of_must_be_used_to >= :dateOfBuy)")
            ->setParameter("dateOfBuy", $dateOfBuy)
            ->orderBy('purchase_abonement.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return PurchaseAbonement[] Returns an array of PurchaseAbonement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PurchaseAbonement
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
