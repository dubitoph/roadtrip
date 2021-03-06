<?php

namespace App\Repository\payment;

use App\Entity\payment\Bill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bill|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bill|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bill[]    findAll()
 * @method Bill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, Bill::class);

    }

    /**
     * @return Bill[]
     */
    public function findOwnerBills($adverts)
    {

        return $this->createQueryBuilder('b')
                    ->andWhere('b.advert IN (:adverts)')
                    ->setParameter('adverts', $adverts)
                    ->orderBy('b.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;

    }
    
}
