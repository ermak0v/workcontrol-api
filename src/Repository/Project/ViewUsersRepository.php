<?php


namespace App\Repository\Project;


use App\Entity\Project\ViewUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ViewUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewUsers[]    findAll()
 * @method ViewUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewUsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewUsers::class);
    }

    // /**
    //  * @return Criterion[] Returns an array of Criterion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Criterion
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}