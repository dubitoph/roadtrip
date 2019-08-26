<?php

namespace App\Repository\media;

use App\Entity\media\Photo;
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
    /**
     * Constructor
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, Photo::class);

    }

    /**
     * Get main photos from an advert collection
     *
     * @param Advert[] $adverts
     * 
     * @return Photo[]
     */
    public function getMainPhotos($adverts): ?array
    {
            
        $query = $this->createQueryBuilder('p')
                      ->andWhere("p.advert IN (:adverts)")
                      ->andWhere("p.mainPhoto = 1")
                      ->setParameter('adverts', $adverts)
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
    
}