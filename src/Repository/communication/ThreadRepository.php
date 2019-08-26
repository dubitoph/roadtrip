<?php

namespace App\Repository\communication;

use App\Entity\user\User;
use App\Entity\user\Owner;
use App\Entity\communication\Thread;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Thread|null find($id, $lockMode = null, $lockVersion = null)
 * @method Thread|null findOneBy(array $criteria, array $orderBy = null)
 * @method Thread[]    findAll()
 * @method Thread[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThreadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Thread::class);
    }

    /**
     * @return []
     */
    public function notReadMessages(User $user = null, Owner $owner = null)
    {
        
        if($user)
        {

            $userThreads = $user->getThreads();

        }

        if($owner)
        {

            $ownerThreads = $owner->getThreads();

        }
        
        
        if ($user || $owner) 
        {        
            
            $query = $this->createQueryBuilder('t')
                          ->select('t.id AS thread')
                          ->addSelect('COUNT(0) AS number')
                          ->leftJoin('t.mails', 'm')
                          ->Where('m.receiver = t.user')
                          ->andWhere('m.isRead IS null')
                          ->andWhere('t.user = :user')
                          ->groupBy('thread')
            ;
            
            if ($owner) 
            {

                $query->setParameter('user', $owner->getUser())
                ;
                
            }
            else 
            {            

                $query->setParameter('user', $user)
                ;

            }

            return $query->getQuery()
                         ->getScalarResult()
            ;

        }
        else 
        {

            return null;

        }

    }

    // /**
    //  * @return Thread[] Returns an array of Thread objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Thread
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
