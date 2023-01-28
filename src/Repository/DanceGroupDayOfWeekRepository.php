<?php

namespace App\Repository;

use App\Entity\DanceGroupDayOfWeek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DanceGroupDayOfWeek>
 *
 * @method DanceGroupDayOfWeek|null find($id, $lockMode = null, $lockVersion = null)
 * @method DanceGroupDayOfWeek|null findOneBy(array $criteria, array $orderBy = null)
 * @method DanceGroupDayOfWeek[]    findAll()
 * @method DanceGroupDayOfWeek[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DanceGroupDayOfWeekRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DanceGroupDayOfWeek::class);
    }

    public function save(DanceGroupDayOfWeek $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DanceGroupDayOfWeek $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?DanceGroupDayOfWeek {
        return $this->createQueryBuilder("dance_group_day_of_week")
            ->andWhere("dance_group_day_of_week.id = :id")
            ->setParameter("id", $id)
            ->orderBy('dance_group_day_of_week.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByDanceGroupIdAndDayOfWeek(int $danceGroupId, int $dayOfWeek): ?DanceGroupDayOfWeek {
        return $this->createQueryBuilder("dance_group_day_of_week")
            ->leftJoin("dance_group_day_of_week.dance_group", "dance_group")
            ->andWhere("dance_group.id = :danceGroupId")
            ->setParameter("danceGroupId", $danceGroupId)
            ->andWhere("dance_group_day_of_week.day_of_week = :dayOfWeek")
            ->setParameter("dayOfWeek", $dayOfWeek)
            ->orderBy('dance_group_day_of_week.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return DanceGroupDayOfWeek[] Returns an array of Abonement objects
    */
    public function listAll(): array
    {
        return $this->createQueryBuilder('dance_group_day_of_week')
            ->orderBy('dance_group_day_of_week.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return DanceGroupDayOfWeek[] Returns an array of Abonement objects
    */
    public function listAllActive(): array
    {
        return $this->createQueryBuilder('dance_group_day_of_week')
            ->innerJoin("dance_group_day_of_week.dance_group", "dance_group")
            ->andWhere("dance_group_day_of_week.status = '1' ")
            ->orderBy('dance_group_day_of_week.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return DanceGroupDayOfWeek[] Returns an array of DanceGroupDayOfWeek objects
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

//    public function findOneBySomeField($value): ?DanceGroupDayOfWeek
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
