<?php

namespace App\Form\advert;

use App\Entity\advert\Advert;
use App\Form\media\PhotoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PhotosAdvertType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('photos', CollectionType::class, array(
                                                            'entry_type' => PhotoType::class,  
                                                            'prototype' => true,
                                                            'allow_add' => true,
                                                            'allow_delete' => true,
                                                            'by_reference' => false,
                                                            'required' => false,
                                                            'label' => false
                                                        )
                 )
            ->add('deletedPhotos', HiddenType::class, array('mapped' => false))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(
                                [
                                    'data_class' => Advert::class, 
                                    'translation_domain' => 'forms'
                                ]
                              )
        ;

    }
    
}
