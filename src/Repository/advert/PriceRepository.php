<?php

namespace App\Repository\advert;

use App\Entity\advert\Price;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Price|null find($id, $lockMode = null, $lockVersion = null)
 * @method Price|null findOneBy(array $criteria, array $orderBy = null)
 * @method Price[]    findAll()
 * @method Price[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, Price::class);
        
    }

   /**
     * Get the minimum price from an advert
     *
     * @param [type] $advert
     * @return Price[]
     */ 
    public function getAdvertMinPrice($advert): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.price = (
                                    SELECT MIN(p2.price)
                                    FROM ' . $this->_entityName . ' p2
                                    WHERE p2.advert = :val
                                  )'
                      )
            ->setParameter('val', $advert)
            ->getQuery()
            ->getResult()
        ;

    }

}
