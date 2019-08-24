<?php

namespace App\Repository\backend;

use App\Entity\backend\Duration;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Duration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Duration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Duration[]    findAll()
 * @method Duration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DurationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Duration::class);
    }

    /**
     * Return durations order by daysNumber ASC
     *
     * @return Duration[]
     */
    public function findAll(): Array
    {

        return $this->findBy(array(), array('daysNumber' => 'ASC'));
        
    }

   /**
    * Get the duration with the minimum days
    *
    * @return Duration
    */
    public function findMinimumDuration(): Duration
    {

        $subquery = $this->createQueryBuilder('d2')
                         ->select('MIN(d2.daysNumber)');

        return $queryBuilder = $this->createQueryBuilder('d')
                                    ->where('d.daysNumber = (' . $subquery->getDQL() . ')')
                                    ->getQuery()
                                    ->getOneOrNullResult()
        ;

    }

    // /**
    //  * @return Duration[] Returns an array of Duration objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Duration
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
