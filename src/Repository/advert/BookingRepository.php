<?php

namespace App\Repository\advert;

use App\Entity\advert\Booking;
use App\Entity\advert\Vehicle;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Booking::class);
    }

     /**
      * @return Booking[]
      */
    public function findBetweenDates($start, $end, Vehicle $vehicle = null)
    {

         $query = $this->createQueryBuilder('b')
                      ->where('b.beginAt BETWEEN :start and :end');

        if (!empty($vehicle))
        {

            $query->andWhere('b.vehicle = :vehicle');

        }					
 
        $query->setParameter('start', $start)
              ->setParameter('end', $end);

        if (!empty($vehicle))
        {

            $query->setParameter('vehicle', $vehicle);

        }
        
        return $query->getQuery()
                     ->getResult()
        ;
    }

    // /**
    //  * @return Booking[] Returns an array of Booking objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Booking
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
