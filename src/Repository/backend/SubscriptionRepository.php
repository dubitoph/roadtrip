<?php

namespace App\Repository\backend;

use App\Entity\backend\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, Subscription::class);

    }

    /**
     * Return durations order by daysNumber ASC
     *
     * @return Subscription[]
     */
    public function findAll(): Array
    {

        return $this->findBy(array(), array('price' => 'ASC'));
        
    }
    
}
