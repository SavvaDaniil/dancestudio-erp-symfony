<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id): ?User {
        return $this->createQueryBuilder("user")
            ->andWhere("user.id = :id")
            ->setParameter("id", $id)
            ->orderBy('user.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }


    
    public function findByUsername(string $username): ?User {
        return $this->createQueryBuilder("user")
            ->andWhere("user.username = :username")
            ->setParameter("username", $username)
            ->orderBy('user.id', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
    
    /**
    * @return User[] Returns an array of Abonement objects
    */
    public function search(int $page, ?string $queryString): array
    {
        $page--;
        if($queryString == "")$queryString = null;
        if($page < 0)$page = 0;
        $query = $this->createQueryBuilder('user');
        if(!(is_null($queryString))){
            $query->where(
                $query->expr()->like("user.secondname", ":query_string"),
                $query->expr()->like("user.firstname", ":query_string"),
                $query->expr()->like("user.patronymic", ":query_string"),
                $query->expr()->like("user.telephone", ":query_string"),
                $query->expr()->like("user.secondname", ":query_string")
            );
            $query->setParameter("query_string", "%".$queryString."%");
        }
            return $query->orderBy('user.id', 'DESC')
            ->setFirstResult($page * 20)
            ->setMaxResults(20)
            ->getQuery()
            ->getResult();
    }
    

    public function countByQuery(?string $queryString): int
    {
        if($queryString == "")$queryString = null;
        $query = $this->createQueryBuilder('user')
        ->select("COUNT(user.id)");
        if(!(is_null($queryString))){
            $query->where(
                $query->expr()->like("user.secondname", ":query_string"),
                $query->expr()->like("user.firstname", ":query_string"),
                $query->expr()->like("user.patronymic", ":query_string"),
                $query->expr()->like("user.telephone", ":query_string"),
                $query->expr()->like("user.secondname", ":query_string")
            );
            $query->setParameter("query_string", "%".$queryString."%");
        }
        return $query->orderBy('user.id', 'DESC')
        ->getQuery()
        ->getSingleScalarResult();
    }
    

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
