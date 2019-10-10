<?php

namespace App\Repository\backend;

use App\Entity\backend\Equipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Equipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Equipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Equipment[]    findAll()
 * @method Equipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipmentRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, Equipment::class);

    }
    
    public function queryFindByBelonging(String $belonging) 
    {

        $query = $this->createQueryBuilder('r')
                      ->andWhere('r.belonging = :belonging')
                      ->setParameter('belonging', $belonging);
    
        return $query;

    }
    
    public function findByBelonging(String $belonging)
    {

        return $this->createQueryBuilder('r')
                    ->getQuery()
                    ->getResult();

    }
    
}
