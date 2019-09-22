<?php

namespace App\Repository\booking;

use App\Entity\booking\Booking;
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
                      ->where('b.beginAt BETWEEN :start and :end')
                      ->andWhere('b.accepted = true')
                      ->andWhere('b.deleted is null')
        ;

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

     /**
      * @return Booking[]
      */
    public function findOpenedRequests($ownerVehicles)
    {
        
        return $this->createQueryBuilder('b')
                    ->andWhere('b.vehicle IN (:ownerVehicles)')
                    ->andWhere('b.accepted is NULL')
                    ->andWhere('b.refused is NULL')
                    ->setParameter('ownerVehicles', $ownerVehicles)
                    ->orderBy('b.createdAt', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return Booking[]
     */
   public function findRefusedRequests($ownerVehicles)
   {
       
       return $this->createQueryBuilder('b')
                   ->andWhere('b.vehicle IN (:ownerVehicles)')
                   ->andWhere('b.accepted is NULL')
                   ->andWhere('b.refused = true')
                   ->setParameter('ownerVehicles', $ownerVehicles)
                   ->orderBy('b.createdAt', 'DESC')
                   ->getQuery()
                   ->getResult()
       ;
   }

   /**
    * @return Booking[]
    */
  public function findBookingsWithoutRating($user)
  {
      
      return $this->createQueryBuilder('b')
                  ->leftJoin('App\Entity\rating\Rating', 'r', "WITH", 'r.booking = b AND r.user = :user')
                  ->andWhere('r.booking is null')
                  ->setParameter('user', $user)
                  ->orderBy('b.createdAt', 'ASC')
                  ->getQuery()
                  ->getResult()
      ;
  }

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
