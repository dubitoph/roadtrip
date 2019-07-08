<?php

namespace App\Repository\advert;

use App\Entity\advert\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Photo::class);
    }

         /**
          * @param Advert[] $adverts
          * @return Photo[]
          */
        public function getMainPhotos($adverts)
        {
            
            $advertsIds = array();

            foreach ($adverts as $advert) 
            {

                $advertIds[] = $advert->getId();

            }
            
            $query = $this->createQueryBuilder('p')
                        ->andWhere("p.advert IN (:advertsIds)")
                        ->andWhere("p.mainPhoto = 1")
                        ->setParameter('advertsIds', $advertIds)
                        ->getQuery()
                        ->getResult()
            ;
            
            $photos = array();
            
            foreach ($query as $photo) 
            {

                $photos[$photo->getAdvert()->getId()] = $photo;

            }

            return $photos;
            
        }

    // /**
    //  * @return Photo[] Returns an array of Photo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Photo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
