<?php

namespace App\Repository\rating;

use App\Entity\rating\ResponseToRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResponseToRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseToRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseToRating[]    findAll()
 * @method ResponseToRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseToRatingRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, ResponseToRating::class);
        
    }
    
}
