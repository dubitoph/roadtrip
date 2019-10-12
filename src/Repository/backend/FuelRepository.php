<?php

namespace App\Repository\backend;

use App\Entity\backend\Fuel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Fuel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fuel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fuel[]    findAll()
 * @method Fuel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuelRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, Fuel::class);
        
    }

}
