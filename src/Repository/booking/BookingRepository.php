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
                      ->where('(b.beginAt BETWEEN :start and :end) or (b.endAt BETWEEN :start and :end)')
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
                    ->andWhere('b.deleted is NULL')
                    ->setParameter('ownerVehicles', $ownerVehicles)
                    ->orderBy('b.createdAt', 'ASC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    /**
     * @return int
     */
   public function findOpenedRequestsNumber($ownerVehicles)
   {
       
        return $this->createQueryBuilder('b')
                    ->select('count(b.id)')
                    ->andWhere('b.vehicle IN (:ownerVehicles)')
                    ->andWhere('b.accepted is NULL')
                    ->andWhere('b.refused is NULL')
                    ->andWhere('b.deleted is NULL')
                    ->setParameter('ownerVehicles', $ownerVehicles)
                    ->getQuery()
                    ->getSingleScalarResult()
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

    $now = date("Y-m-d");
      
    return $this->createQueryBuilder('b')
                ->where('b.accepted = true')
                ->andWhere('b.deleted is null')
                ->andWhere('b.beginAt < :now')
                ->leftJoin('App\Entity\rating\Rating', 'r', "WITH", 'r.booking = b AND r.user = :user')
                ->andWhere('r.booking is null')
                ->setParameter('now', $now)
                ->setParameter('user', $user)
                ->orderBy('b.createdAt', 'ASC')
                ->getQuery()
                ->getResult()
      ;
  }
  
}
