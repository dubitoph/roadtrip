<?php

namespace App\Listener;

use App\Entity\media\Photo;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Filesystem\Filesystem;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoCacheSubscriber implements EventSubscriber
{

    /**
     * @var CacheManager
     */
    private $cacheManager;
    
    public function __construct(ContainerInterface $container, CacheManager $cacheManager)
    {

        $this->cacheManager = $cacheManager;
        $this->container = $container;

    }
    
    public function getSubscribedEvents()
    {

        return [
                'preRemove',
                'preUpdate'
               ]
        ;

    }

    public function preRemove(LifecycleEventArgs $args)
    {
        
        $entity = $args->getEntity();
        
        if (! $entity instanceof Photo) 
        {

            return;

        }        
        else 
        {

            $fileSystem = new Filesystem();
            
            $photoFile = $this->container->getParameter('photos_directory') . '/' . $entity->getName(); 
            
            $fileSystem->remove($photoFile); 
            $this->cacheManager->remove($entity->getFile());

        }

    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        
        $entity = $args->getEntity();
        
        if (! $entity instanceof Photo) 
        {

            return;

        }
        
        if ($entity->getFile() instanceof UploadedFile) 
        {
            
            $fileSystem = new Filesystem();
            
            $photoFile = $this->container->getParameter('photos_directory') . '/' . $entity->getName();
            
            $fileSystem->remove($photoFile); 
            $this->cacheManager->remove($entity->getFile());

        }

    }

}