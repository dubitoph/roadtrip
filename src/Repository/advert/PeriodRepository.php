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
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Period::class);
    }

    /**
     * @return Period[] Returns an array of Period objects
     */
    
    public function findByAdvert($advert)
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
    
    /*
    public function findOneBySomeField($value): ?Period
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
