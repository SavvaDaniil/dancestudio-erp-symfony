<?php

namespace App\Repository;

use App\Entity\Visit;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visit>
 *
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    public function save(Visit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Visit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?Visit {
        return $this->createQueryBuilder("visit")
            ->andWhere("visit.id = :id")
            ->setParameter("id", $id)
            ->orderBy('visit.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return Visit[] Returns an array of Abonement objects
    */
    public function listAllByUserId(int $userId): array
    {
        return $this->createQueryBuilder('visit')
            ->leftJoin("visit.user", "user")
            ->innerJoin("visit.dance_group", "dance_group")
            ->innerJoin("visit.dance_group_day_of_week", "dance_group_day_of_week")
            ->innerJoin("visit.purchase_abonement", "purchase_abonement")
            ->andWhere("user.id = :userId")
            ->setParameter("userId", $userId)
            ->orderBy('visit.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return Visit[] Returns an array of Abonement objects
    */
    public function listAllOnDateOfActionIncludePurchaseAbonementAndDanceGroup(DateTime $dateOfAction): array
    {
        return $this->createQueryBuilder('visit')
            ->andWhere("visit.date_of_buy = :dateOfAction")
            ->setParameter("dateOfAction", $dateOfAction)
            ->innerJoin("visit.purchase_abonement", "purchase_abonement")
            ->innerJoin("visit.dance_group", "dance_group")
            ->orderBy('visit.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return Visit[] Returns an array of Abonement objects
    */
    public function listAllByDanceGroupIdOnDateOfAction(int $danceGroupId, DateTime $dateOfAction): array
    {
        return $this->createQueryBuilder('visit')
            ->leftJoin("visit.dance_group", "dance_group")
            ->andWhere("visit.date_of_buy = :dateOfAction")
            ->setParameter("dateOfAction", $dateOfAction)
            ->andWhere("dance_group.id = :danceGroupId")
            ->setParameter("danceGroupId", $danceGroupId)
            ->innerJoin("visit.user", "user")
            ->innerJoin("visit.dance_group_day_of_week", "dance_group_day_of_week")
            ->innerJoin("visit.purchase_abonement", "purchase_abonement")
            ->orderBy('visit.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return Visit[] Returns an array of Abonement objects
    */
    public function listAllByUserIdAndDanceGroupIdOnDateOfAction(int $userId, int $danceGroupId, DateTime $dateOfAction): array
    {
        return $this->createQueryBuilder('visit')
            ->leftJoin("visit.user", "user")
            ->leftJoin("visit.dance_group", "dance_group")
            ->andWhere("visit.date_of_buy = :dateOfAction")
            ->setParameter("dateOfAction", $dateOfAction)
            ->andWhere("dance_group.id = :danceGroupId")
            ->setParameter("danceGroupId", $danceGroupId)
            ->innerJoin("visit.dance_group_day_of_week", "dance_group_day_of_week")
            ->innerJoin("visit.purchase_abonement", "purchase_abonement")
            ->andWhere("user.id = :userId")
            ->setParameter("userId", $userId)
            ->orderBy('visit.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return Visit[] Returns an array of Abonement objects
    */
    public function listAllByUserIdAndDanceGroupId(int $userId, int $danceGroupId): array
    {
        return $this->createQueryBuilder('visit')
            ->leftJoin("visit.user", "user")
            ->leftJoin("visit.dance_group", "dance_group")
            ->andWhere("dance_group.id = :danceGroupId")
            ->setParameter("danceGroupId", $danceGroupId)
            ->innerJoin("visit.dance_group_day_of_week", "dance_group_day_of_week")
            ->innerJoin("visit.purchase_abonement", "purchase_abonement")
            ->andWhere("user.id = :userId")
            ->setParameter("userId", $userId)
            ->orderBy('visit.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Visit[] Returns an array of Visit objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Visit
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
