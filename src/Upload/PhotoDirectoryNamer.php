<?php

namespace App\Upload;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class PhotoDirectoryNamer implements DirectoryNamerInterface
{
    
    public function directoryName($object, PropertyMapping $mapping): string
    {

        $advert = $object->getAdvert();
        
        if($object->getAdvert())
        {

            return sprintf('%s/%s', 'adverts', $advert->getId());
            
        }
        else 
        {

            return sprintf('%s/%s', 'profiles', $object->getProfile()->getUser()->getId());

        }
                                                                                           
    }
}