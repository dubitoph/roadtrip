<?php

namespace App\Repository\backend;

use App\Entity\backend\Sort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Sort|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sort|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sort[]    findAll()
 * @method Sort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sort::class);
    }

    // /**
    //  * @return Sort[] Returns an array of Sort objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sort
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
