<?php

namespace App\Repository\backend\FAQ;

use App\Entity\backend\FAQ\FaqCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FaqCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method FaqCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method FaqCategory[]    findAll()
 * @method FaqCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FaqCategoryRepository extends ServiceEntityRepository
{

    public function __construct(RegistryInterface $registry)
    {

        parent::__construct($registry, FaqCategory::class);

    }

    /**
     * Get all categories sorted by alphabetical order
     *
     * @return void
     */
    public function findAll()
    {

        return $this->findBy(array(), array('category' => 'ASC'));

    }
    
}
