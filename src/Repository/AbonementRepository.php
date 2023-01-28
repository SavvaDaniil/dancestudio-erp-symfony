<?php

namespace App\Repository;

use App\Entity\Abonement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Abonement>
 *
 * @method Abonement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonement[]    findAll()
 * @method Abonement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonement::class);
    }

    public function save(Abonement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Abonement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?Abonement {
        return $this->createQueryBuilder("abonement")
            ->andWhere("abonement.id = :id")
            ->setParameter("id", $id)
            ->orderBy('abonement.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return Abonement[] Returns an array of Abonement objects
    */
    public function listAll(): array
    {
        return $this->createQueryBuilder('abonement')
            ->orderBy('abonement.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return Abonement[] Returns an array of Abonement objects
    */
    public function listAllActive(): array
    {
        return $this->createQueryBuilder('abonement')
            ->andWhere("abonement.status_of_visible = '1'")
            ->andWhere("abonement.status_of_deleted = '0'")
            ->orderBy('abonement.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
    * @return Abonement[] Returns an array of Abonement objects
    */
    public function listAllActiveConnectedToDanceGroup(int $danceGroupId): array
    {
        return $this->createQueryBuilder('abonement')
            ->innerJoin("connection_abonement_to_dance_group.dance_group", "dance_group")
            ->innerJoin("connection_abonement_to_dance_group.abonement", "abonement_connected")
            ->andWhere("dance_group.id = :danceGroupId")
            ->setParameter("danceGroupId", $danceGroupId)
            ->andWhere("abonement_connected.id = abonement.id")
            ->andWhere("abonement.status_of_visible = '1'")
            ->andWhere("abonement.status_of_deleted = '0'")
            ->orderBy('abonement.id', 'DESC')
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Abonement[] Returns an array of Abonement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Abonement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
