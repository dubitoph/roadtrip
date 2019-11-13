<?php

namespace App\Repository\rating;

use App\Entity\user\User;
use App\Entity\user\Owner;
use App\Entity\advert\Advert;
use App\Entity\rating\Rating;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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
    
    /**
     * Get approved ratings from somes adverts
     *
     * @param Advert[] $adverts
     * 
     * @return Rating[]|null
     */
    public function findByAdverts(Advert $adverts): ?array
    {

        $now = date("Y-m-d");
        
        return $this->createQueryBuilder('r')
                    ->addSelect('a.id')
                    ->join('r.booking', 'b')
                    ->join('App\Entity\advert\Advert', 'a')
                    ->andWhere('a = b.vehicle')
                    ->andWhere('a in (:adverts)')
                    ->andWhere('r.approvedRating = true')
                    ->andWhere('b.endAt <= :now')
                    ->groupBy('a.id')
                    ->setParameter('adverts', $adverts)
                    ->setParameter('now', $now)
                    ->getQuery()
                    ->getResult()
        ;

    }
    
    /**
     * Get an user's received ratings
     *
     * @param User $user
     * 
     * @return Rating[]|null
     */
    public function findReceivedUserRatings(User $user): ?array
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
    
    /**
     * Get an owner's received ratings
     *
     * @param Owner $owner
     * 
     * @return Rating[]|null
     */
    public function findReceivedOwnerRatings(Owner $owner): ?array
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
    
    /**
     * Get an user's given ratings
     *
     * @param Owner $owner
     * 
     * @return Rating[]|null
     */
    public function findGivenUserRatings(Owner $owner): ?array
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
    
    /**
     * Get an user's given ratings to owners
     *
     * @param [type] $user
     * 
     * @return Rating[]|null
     */
    public function findGivenOwnerRatings(User $user): ?array
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
    
    /**
     * Get an user's given ratings to tenants
     *
     * @param [type] $user
     * 
     * @return Rating[]|null
     */
    public function findGivenTenantRatings(User $user): ?array
    {

        return $this->createQueryBuilder('r')
                    ->join('r.booking', 'b')
                    ->where('b.user <> :user')
                    ->andWhere('r.user = :user')
                    ->orderBy('r.createdAt', 'DESC')
                    ->setParameter('user', $user)
                    ->getQuery()
                    ->getResult()
        ;

    }

}
