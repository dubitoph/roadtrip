<?php

namespace App\Repository\advert;

use App\Entity\advert\Period;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Period|null find($id, $lockMode = null, $lockVersion = null)
 * @method Period|null findOneBy(array $criteria, array $orderBy = null)
 * @method Period[]    findAll()
 * @method Period[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeriodRepository extends ServiceEntityRepository
{

    /**
     * Constructor
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Period::class);
    }

    /**
     * Return the periods linked to a specific advert
     *
     * @param [type] $advert
     * @return Period[]|null
     */
    public function findByAdvert($advert): ?array
    {

        $format = 'Y-m-d H:i:s';
        $date = date("Y-m-d 00:00:00");
        $today = \DateTime::createFromFormat($format, $date);
        
        return $this->createQueryBuilder('p')
                    ->andWhere('p.advert = :advert')
                    ->andWhere('p.start >= :today')
                    ->setParameter('advert', $advert)
                    ->setParameter('today', $today)
                    ->orderBy('p.start', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;

    }
    
}
