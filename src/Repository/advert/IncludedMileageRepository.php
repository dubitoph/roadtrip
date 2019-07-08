<?php

namespace App\Repository\advert;

use App\Entity\advert\IncludedMileage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IncludedMileage|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncludedMileage|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncludedMileage[]    findAll()
 * @method IncludedMileage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncludedMileageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncludedMileage::class);
    }

    // /**
    //  * @return IncludedMileage[] Returns an array of IncludedMileage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IncludedMileage
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
