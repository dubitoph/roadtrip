<?php

namespace App\Repository\advert;

use App\Entity\advert\InsurancePrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InsurancePrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method InsurancePrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method InsurancePrice[]    findAll()
 * @method InsurancePrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InsurancePriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InsurancePrice::class);
    }

    // /**
    //  * @return InsurancePrice[] Returns an array of InsurancePrice objects
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
    public function findOneBySomeField($value): ?InsurancePrice
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
