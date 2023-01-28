<?php

namespace App\Repository;

use App\Entity\TeacherSalary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use DateTime;

/**
 * @extends ServiceEntityRepository<TeacherSalary>
 *
 * @method TeacherSalary|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeacherSalary|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeacherSalary[]    findAll()
 * @method TeacherSalary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherSalaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeacherSalary::class);
    }

    public function save(TeacherSalary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TeacherSalary $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?TeacherSalary {
        return $this->createQueryBuilder("teacher_salary")
            ->andWhere("teacher_salary.id = :id")
            ->innerJoin("teacher_salary.dance_group", "dance_group")
            ->innerJoin("teacher_salary.teacher", "teacher")
            ->setParameter("id", $id)
            ->orderBy('teacher_salary.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return TeacherSalary[] Returns an array of Abonement objects
    */
    public function search(DateTime $dateFrom, DateTime $dateTo, int $danceGroupId, int $teacherId): array
    {
        $query = $this->createQueryBuilder('teacher_salary')
            //->innerJoin("teacher_salary.dance_group", "dance_group")
            //->innerJoin("teacher_salary.teacher", "teacher")
            ->andWhere("teacher_salary.date_of_action > :dateFrom OR teacher_salary.date_of_action = :dateFrom")
            ->andWhere("teacher_salary.date_of_action < :dateTo OR teacher_salary.date_of_action = :dateTo")
            ->setParameter("dateFrom", $dateFrom)
            ->setParameter("dateTo", $dateTo);

        if($danceGroupId != 0){
            $query->leftJoin("teacher_salary.dance_group", "dance_group")
            ->andWhere("dance_group.id = :danceGroupId")
            ->setParameter("danceGroupId", $danceGroupId);
        } else {
            $query->innerJoin("teacher_salary.dance_group", "dance_group");
        }

        if($teacherId != 0){
            $query->leftJoin("teacher_salary.teacher", "teacher")
            ->andWhere("teacher.id = :teacherId")
            ->setParameter("teacherId", $teacherId);
        } else {
            $query->innerJoin("teacher_salary.teacher", "teacher");
        }

        return $query->orderBy('teacher_salary.id', "DESC")
        ->getQuery()
        ->getResult();
    }
    
    /**
    * @return TeacherSalary[] Returns an array of Abonement objects
    */
    public function listAllOnDateOfActionIncludeDanceGroup(DateTime $dateOfAction): array
    {
        return $this->createQueryBuilder('teacher_salary')
            ->innerJoin("teacher_salary.dance_group", "dance_group")
            ->andWhere("teacher_salary.date_of_action = :dateOfAction")
            ->setParameter("dateOfAction", $dateOfAction)
            ->orderBy('teacher_salary.id', "DESC")
            ->getQuery()
            ->getResult();
    }

    public function findByTeacherIdAndDanceGroupIdOnDateOfAction(int $teacherId, int $dancedGroupId, DateTime $dateOfAction): ?TeacherSalary {
        return $this->createQueryBuilder("teacher_salary")
            ->leftJoin("teacher_salary.teacher", "teacher")
            ->andWhere("teacher.id = :teacherId")
            ->setParameter("teacherId", $teacherId)
            ->leftJoin("teacher_salary.dance_group", "dance_group")
            ->andWhere("dance_group.id = :dancedGroupId")
            ->setParameter("dancedGroupId", $dancedGroupId)
            ->andWhere("teacher_salary.date_of_action = :dateOfAction")
            ->setParameter("dateOfAction", $dateOfAction)
            ->orderBy('teacher_salary.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return TeacherSalary[] Returns an array of Abonement objects
    */
    public function listAllByDanceGroupIdOnDateOfAction(int $dancedGroupId, DateTime $dateOfAction): array
    {
        return $this->createQueryBuilder('teacher_salary')
            ->innerJoin("teacher_salary.dance_group", "dance_group")
            ->andWhere("dance_group.id = :dancedGroupId")
            ->setParameter("dancedGroupId", $dancedGroupId)
            ->andWhere("teacher_salary.date_of_action = :dateOfAction")
            ->setParameter("dateOfAction", $dateOfAction)
            ->orderBy('teacher_salary.id', "DESC")
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return TeacherSalary[] Returns an array of TeacherSalary objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TeacherSalary
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
