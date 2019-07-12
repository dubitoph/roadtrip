<?php

namespace App\Repository\communication;

use App\Entity\communication\Mail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Mail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mail[]    findAll()
 * @method Mail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Mail::class);
    }

    /**
     * @return Mail[]
     */
    public function findMailsAboutAdvert($user)
    {
        return $this->createQueryBuilder('m')
                    ->andWhere('m.sender = :user')
                    ->setParameter('user', $user)
                    ->orderBy('m.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Mail
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
