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
    
    public function findByAdverts($adverts)
    {

        $now = date("Y-m-d");
        
        return $this->createQueryBuilder('r')
                    ->addSelect('a.id')
                    ->join('r.booking', 'b')
                    ->join('App\Entity\advert\Advert', 'a')
                    ->andWhere('a = b.vehicle')
                    ->andWhere('a in (:adverts)')
                    ->andWhere('r.ratingApproved = true')
                    ->andWhere('b.endAt <= :now')
                    ->groupBy('a.id')
                    ->setParameter('adverts', $adverts)
                    ->setParameter('now', $now)
                    ->getQuery()
                    ->getResult()
        ;

    }
    
    public function findReceivedUserRatings($user)
    {

        return $this->createQueryBuilder('r')
                    ->join('r.booking', 'b')
                    ->where('b.user = :user')
                    ->andWhere('r.user <> :user')
                    ->orderBy('r.createdAt', 'DESC')
                    ->setParameter('user', $user)
                    ->getQuery()
                    ->getResult()
        ;

    }
    
    public function findReceivedOwnerRatings($owner)
    {

        return $this->createQueryBuilder('r')
                    ->join('r.booking', 'b')
                    ->join('b.vehicle', 'v')
                    ->join('v.advert', 'a')
                    ->where('a.owner = :owner')
                    ->andWhere('r.user <> :user')
                    ->orderBy('r.createdAt', 'DESC')
                    ->setParameter('owner', $owner)
                    ->setParameter('user', $owner->getUser())
                    ->getQuery()
                    ->getResult()
        ;

    }
    
    public function findGivenUserRatings($owner)
    {

        return $this->createQueryBuilder('r')
                    ->join('r.booking', 'b')
                    ->join('b.vehicle', 'v')
                    ->join('v.advert', 'a')
                    ->where('a.owner = :owner')
                    ->andWhere('r.user = :user')
                    ->orderBy('r.createdAt', 'DESC')
                    ->setParameter('owner', $owner)
                    ->setParameter('user', $owner->getUser())
                    ->getQuery()
                    ->getResult()
        ;

    }
    
    public function findGivenOwnerRatings($user)
    {

        return $this->createQueryBuilder('r')
                    ->join('r.booking', 'b')
                    ->where('b.user = :user')
                    ->andWhere('r.user = :user')
                    ->orderBy('r.createdAt', 'DESC')
                    ->setParameter('user', $user)
                    ->getQuery()
                    ->getResult()
        ;

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
