<?php

namespace App\Repository\rating;

use App\Entity\rating\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function toConfirmRental($period)
    {

        $upLimit = new \DateTime("- " . $period);
        $confirmation = 'Yes';

        $query = $this->createQueryBuilder('r')
                         ->update('App\Entity\advert\Rating', 'r')
                         ->set('r.rentalConfirmation', ':confirmation')
                         ->set('r.rentalAutomaticallyConfirmed', true)
                         ->where('r.rentalConfirmation is NULL')
                         ->andWhere('r.createdAt <= :upLimit')
                         ->setParameter('upLimit', $upLimit)
                         ->setParameter('confirmation', $confirmation)
                         ->getQuery();

        $result = $query->execute();

    }
    

    /*
    public function findOneBySomeField($value): ?Rating
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
