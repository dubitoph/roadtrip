<?php

namespace App\Repository\rating;

use App\Entity\rating\ResponseToRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResponseToRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseToRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseToRating[]    findAll()
 * @method ResponseToRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseToRatingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResponseToRating::class);
    }

    // /**
    //  * @return ResponseToRating[] Returns an array of ResponseToRating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ResponseToRating
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
