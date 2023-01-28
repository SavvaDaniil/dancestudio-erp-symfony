<?php

namespace App\Repository;

use App\Entity\DanceGroup;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @extends ServiceEntityRepository<DanceGroup>
 *
 * @method DanceGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method DanceGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method DanceGroup[]    findAll()
 * @method DanceGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DanceGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DanceGroup::class);
    }

    public function save(DanceGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DanceGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?DanceGroup {
        return $this->createQueryBuilder("dance_group")
            ->andWhere("dance_group.id = :id")
            ->setParameter("id", $id)
            ->orderBy('dance_group.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return DanceGroup[] Returns an array of Abonement objects
    */
    public function listAll(): array
    {
        return $this->createQueryBuilder('dance_group')
            ->orderBy('dance_group.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return DanceGroup[] Returns an array of Abonement objects
    */
    public function listAllIncludeTeacher(): array
    {
        return $this->createQueryBuilder('dance_group')
            ->innerJoin("dance_group.teacher", "teacher")
            ->orderBy('dance_group.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return DanceGroup[] Returns an array of Abonement objects
    */
    /*
    public function listAllWithVisitsOnDayOfActionIncludeTeacher(DateTime $dateOfAction): array
    {
        $rsm = new ResultSetMapping;
        //$rsm->addEntityResult('App\Entity\DanceGroup', 'dance_group');
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata('App\Entity\DanceGroup', 'dance_group');

        $rsm->addFieldResult('dance_group', 'id', 'id');
        $rsm->addFieldResult('dance_group', 'name', 'name');
        $rsm->addFieldResult('dance_group', 'status', 'status');
        $rsm->addFieldResult('dance_group', 'description', 'description');
        $rsm->addFieldResult('dance_group', 'status_of_creative', 'status_of_creative');
        $rsm->addFieldResult('dance_group', 'status_for_app', 'status_for_app');
        $rsm->addFieldResult('dance_group', 'is_abonements_allow_all', 'is_abonements_allow_all');
        $rsm->addFieldResult('dance_group', 'is_active_reservation', 'is_active_reservation');
        $rsm->addFieldResult('dance_group', 'is_event', 'is_event');

        //$rsm->addJoinedEntityFromClassMetadata('App\Entity\Teacher', 'teacher', 'dance_group', 'teacher', array('id' => 'teacher_id'));
        $rsm->addJoinedEntityFromClassMetadata('App\Entity\Visit', 'visit', 'dance_group', 'visit', array('id' => 'visit_id'));

        $query = $this->_em->createNativeQuery('SELECT * FROM dance_group INNER JOIN visit ON visit.date_of_buy = ? AND visit.dance_group_id = dance_group.id', $rsm);
        $query->setParameter(1, $dateOfAction->format("Y-m-d"));

        return $query->getResult();
    }
    */

//    /**
//     * @return DanceGroup[] Returns an array of DanceGroup objects
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

//    public function findOneBySomeField($value): ?DanceGroup
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
