<?php

namespace App\Repository;

use App\Entity\TeacherRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeacherRate>
 *
 * @method TeacherRate|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeacherRate|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeacherRate[]    findAll()
 * @method TeacherRate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeacherRate::class);
    }

    public function save(TeacherRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TeacherRate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?TeacherRate {
        return $this->createQueryBuilder("teacher_rate")
            ->andWhere("teacher_rate.id = :id")
            ->setParameter("id", $id)
            ->orderBy('teacher_rate.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return TeacherRate[] Returns an array of Abonement objects
    */
    public function listAllByTeacherIdOrderByStudents(int $teacherId): array
    {
        return $this->createQueryBuilder('teacher_rate')
            ->innerJoin("teacher_rate.teacher", "teacher")
            ->andWhere("teacher.id = :teacherId")
            ->setParameter("teacherId", $teacherId)
            ->orderBy('teacher_rate.students')
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return TeacherRate[] Returns an array of TeacherRate objects
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

//    public function findOneBySomeField($value): ?TeacherRate
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
